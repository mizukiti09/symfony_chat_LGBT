<?php
namespace App\Controller;

use App\Form\UserType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\sComponent\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SecurityController extends AbstractController
{
  /**
   * @Route("/login", name="login")
   */
  public function login(SessionInterface $session, AuthenticationUtils $authenticationUtils)
  {
    $error = $authenticationUtils->getLastAuthenticationError();

    
    $userData = $this->getUser();

    if($userData == null){
      $user = 'not logined...';
      $u_id = 0;
    } else {
        $user = 'logined: '. $userData->getUsername();
        return $this->redirect('/contribute/page');
        $u_id = $userData->getId();
    }
    return $this->render('security/login.html.twig', array(
      'error' => $error,
      'user' => $user,
      'user_id' => $u_id,
      'userData' => $userData,
    ));
  }
}