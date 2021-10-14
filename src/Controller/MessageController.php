<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Message;
use App\Entity\Bord;
use App\Entity\Contribute;
use App\Form\MessageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class MessageController extends AbstractController
{
    /**
     * @Route("/message_prev", name="message_prev")
     */
    public function prev(Request $request)
    {


        if($request->getMethod() == 'POST'){
            dd($request->request->get('message_prev'));

            $userData = $this->getUser();

            $contribute_id = $request->get('contribute_id');
            $contribute_user_id = $request->get('contribute_user_id');
            $userId = $userData->getId();

            $bord = new Bord();
            $contribute = new Contribute();
            $user = new User();

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

        

        // return $this->render('message/prev.html.twig', [
        //     'userData' => $userData,
        //     'user_id' => $userData->getId(),
        //     'title' => 'メッセージ前',
        // ]);
    }

    /**
     * @Route("/message?b_id={bord_id}&c_id={contribute_id}&c_u_id={contribute_user_id}", name="message")
     */
    public function message(SessionInterface $session,Request $request): Response
    {   
        $userData = $this->getUser();
        $repository = $this->getDoctrine()->getRepository(Message::class);


        $user = new User();
        $bord = new Bord();

        $session_userId = $session->get('user_id');
        $contribute_id = $request->get('contribute_id');
        $contribute_user_id = $request->get('contribute_user_id');
        $bordId = $request->get('bord_id');
        
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);

        $myMsgData = $repository->myMessage($session_userId);
        $userId = $userData->getId();
        
        $guest_id = '';
        foreach($myMsgData as $key => $value){
            if($value['bord_id'] == $bordId){
                $guest_id = $value['from_user_id'];
            }
        }
        
        

        if($request->getMethod() == 'POST'){
            $text = $form->get('message')->getData();

            if($userId == $session_userId and $userId !== (int)$contribute_user_id){
                $manager = $this->getDoctrine()->getManager();

                $message->setFromUser($manager->getReference('App\Entity\User', $userId));
                $message->setToUser($manager->getReference('App\Entity\User',  $contribute_user_id));
                $message->setMessage($text);
                $message->setBord($manager->getReference('App\Entity\Bord', $bordId));
                $message->setContribute($manager->getReference('App\Entity\Contribute', $contribute_id));
                $message->setDeleteFlg(1);

                
                $manager->persist($message);
                $manager->flush();
                return $this->redirect($this->generateUrl('message', array('bord_id' => $bordId, 'contribute_id' => $contribute_id, 'contribute_user_id' => $contribute_user_id)));
            } else {
                $manager = $this->getDoctrine()->getManager();

                $message->setFromUser($manager->getReference('App\Entity\User', $userId));
                $message->setToUser($manager->getReference('App\Entity\User',  $guest_id));
                $message->setMessage($text);
                $message->setBord($manager->getReference('App\Entity\Bord', $bordId));
                $message->setContribute($manager->getReference('App\Entity\Contribute', $contribute_id));
                $message->setDeleteFlg(1);
                
                $manager->persist($message);
                $manager->flush();
                return $this->redirect($this->generateUrl('message', array('bord_id' => $bordId, 'contribute_id' => $contribute_id, 'contribute_user_id' => $contribute_user_id)));
            }

        }

        $msgData = $repository->findBordMessage($bordId);
        

        return $this->render('message/message.html.twig', [
            'form' => $form->createView(),
            'title' => 'メッセージ',
            'data' => $msgData,
            'user_id' => $userId,
            'userData' => $userData,
        ]);
    }

    /**
     * @Route("message/list/{user_id}", name="message_list")
     */
    public function list(Request $request)
    {
        $userData = $this->getUser();
        $repository = $this->getDoctrine()->getRepository(Message::class);

        $c_repository = $this->getDoctrine()->getRepository(Contribute::class);

        $userId = $request->get('user_id');


        $myContributeData =  $c_repository->getMyContribute($userId);

        $myMsgData = $repository->myMessage($userId);
        // dd($myMsgData);
        

        return $this->render('message/list.html.twig', [
            'title' => 'message_list',
            'myContributeData' => $myContributeData,
            'myMsgData' => $myMsgData,
            'user_id' => $userId,
            'userData' => $userData,
        ]);
    }

    /**
     * @Route("message/list/guest/{user_id}", name="message_list_guest")
     */
    public function listGuest(Request $request)
    {
        $userData = $this->getUser();
        $repository = $this->getDoctrine()->getRepository(Message::class);

        $userId = $request->get('user_id');

        $guestWhichContribute = $repository->guestWhichContribute($userId);
        // dd($guestWhichContribute);

        $myMsgGuestData = $repository->myMessageGuest($userId);
        // dd($myMsgGuestData);

        return $this->render('message/listGuest.html.twig', [
            'title' => 'message_listGuest',
            'guestWhichContributeData' => $guestWhichContribute,
            'myMsgGuestData' => $myMsgGuestData,
            'user_id' => $userId,
            'userData' => $userData,
        ]);
    }
}
