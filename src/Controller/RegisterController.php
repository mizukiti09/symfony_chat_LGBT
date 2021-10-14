<?php
namespace App\Controller;

use App\Form\UserType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;



class RegisterController extends AbstractController
{
  /**
   * @Route("/register", name="register")
   */
  public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, ValidatorInterface $validator, SluggerInterface $slugger)
  {
    $user = new User();

    $userData = $this->getUser();
        if($userData == null){
            $u_id = 0;
        } else {
            $u_id = $userData->getId();
        }

    $form = $this->createForm(UserType::class, $user);

    $form->handleRequest($request);

    if($request->getMethod() == 'POST'){
      if($form->isValid()){
        $password = $passwordEncoder->encodePassword($user, $user->getPassword());
        $user->setPassword($password);
        
        $imgFile = $form->get('image')->getData();

        if($imgFile){
          $originalFileName = pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);
          $safeFileName = $slugger->slug($originalFileName);
          $newFileName = $safeFileName.'-'.uniqid().'.'.$imgFile->guessExtension();

          $imgFile->move(
            $this->getParameter('images'),
            $newFileName
          );
        }

        $user->setImage($newFileName);


        $manager = $this->getDoctrine()->getManager();
        $manager->persist($user);
        $manager->flush();
        return $this->redirectToRoute('login');
      }
    }

    return $this->render(
      'registration/register.html.twig', array(
        'form' => $form->createView(),
        'title' => 'ユーザー登録',
        'user_id' => $u_id,
        'userData' => $userData,
      ));

  }
}