<?php

namespace App\Controller;

use App\Form\UserType;
use App\Form\AreaSearchType;
use App\Form\ContributeType;
use App\Entity\Contribute;
use App\Entity\User;
use App\Entity\Bord;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ContributeController extends AbstractController
{
    /**
     * @Route("/contribute/create", name="contribute_create")
     */
    public function create(Request $request, ValidatorInterface $validator): Response
    {

        $userData = $this->getUser();

        $u_id = $userData->getId();

        $contribute = new Contribute();

        $form = $this->createForm(ContributeType::class, $contribute);

        $form->handleRequest($request);

        if($request->getMethod() == 'POST'){
            if($form->isValid()){
                $manager = $this->getDoctrine()->getManager();
                $contribute->setUser($manager->getReference('App\Entity\User', $u_id));
                
                $manager->persist($contribute);
                $manager->flush();
                return $this->redirectToRoute('contribute/page/area');
            }
        }

        return $this->render('contribute/create.html.twig', [
            'title' => '投稿ページ',
            'user' => $userData->getUsername(),
            'userData' => $userData,
            'user_id' => $userData->getId(),
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/contribute/page/{page}/{area}", name="contribute/page/area")
     */
    public function page(SessionInterface $session,Request $request, $page=1, $area='全エリア')
    {
        $post = $request->request->all();
        $userData = $this->getUser();
        if($userData == null){
            $user = 'not logined...';
            $u_id = 0;
        } else {
            $user = 'logined: '. $userData->getUsername();
            $u_id = $userData->getId();
            $session->set('user_id', $u_id);
        }


        $repository = $this->getDoctrine()->getRepository(Contribute::class);

        $repository_bord = $this->getDoctrine()->getRepository(Bord::class);


        $searchFormInst = new User();
        $searchForm = $this->createForm(AreaSearchType::class, $searchFormInst);
        $searchForm->handleRequest($request);

        $bord = new Bord();
        
        if($request->getMethod() == 'POST'){
            if($searchForm->isSubmitted()){
                $area = $searchForm->getData()->getArea();
                $limit = 3;
                $requestData = $searchForm->getData();
                $paginator = $repository->getPageArea($page, $limit, $area);
                $paginator->setUseOutputWalkers(false);
            
                $maxPages = ceil($paginator->count() / $limit);
                
    
                return $this->render('contribute/page.html.twig', [
                    'area' => $area,
                    'form' => $searchForm->createView(),
    
                    'user' => $user,
                    'userData' => $userData,
                    'contribute_page' => $paginator->getIterator(),
                    'maxPages' => $maxPages,
                    'thisPage' => $page,
                    'area' => $area,
                    'user_id' => $u_id,
                    ],
                );
            } else {
                $userData = $this->getUser();

                $contribute_id = $request->request->get('contribute_id');
                $contribute_user_id = $request->request->get('contribute_user_id');
                $userId = $userData->getId();

                $manager = $this->getDoctrine()->getManager();

                $bord->setContribute($manager->getReference('App\Entity\Contribute', $contribute_id));
                $bord->setContributeUser($manager->getReference('App\Entity\User', $contribute_user_id));
                $bord->setUser($manager->getReference('App\Entity\User', $userId));
                $bord->setDeleteFlg(1);

                $manager->persist($bord);
                $manager->flush();

                $last_insert_id = $bord->getId();
            
                return $this->redirect($this->generateUrl('message', array('bord_id' => $last_insert_id, 'contribute_id' => $contribute_id, 'contribute_user_id' => $contribute_user_id)));
                }
        }
        
        
        $limit = 3;
        $paginator = $repository->getPageArea($page, $limit, $area);
        $paginator->setUseOutputWalkers(false);
        
        $maxPages = ceil($paginator->count() / $limit);

        
        return $this->render('contribute/page.html.twig', [
            'form' => $searchForm->createView(),
            'user' => $user,
            'userData' => $userData,
            'contribute_page' => $paginator->getIterator(),
            'maxPages' => $maxPages,
            'thisPage' => $page,
            'area' => $area,
            'user_id' => $u_id,
        ]);

    }
}
