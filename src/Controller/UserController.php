<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contribute;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class UserController extends AbstractController
{
  /**
  * @Route("/my_info/{id}", name="my_info")
  */
  public function myInfo(SessionInterface $session,Request $request, SluggerInterface $slugger, User $user)
  {
    $userData = $this->getUser();
    
    $userId = $this->getUser()->getId();
    $repository = $this->getDoctrine()->getRepository(User::class);
    $data = $repository->findOneBy(array('id' => $userId));

    
    $form = $this->createFormBuilder($user)
    ->add('image', FileType::class, [
      'label' => '画像',
      'attr' => [
        'class' => 'form-control',
      ],
      "data_class" => null,
      ])
      ->add('username', TextType::class, [
        // 'data' =>  $data->getUsername(),
        'label' => '名前',
        'attr' => [
          'class' => 'form-control',
        ],
        ])
      ->add('sex', ChoiceType::class, [
          'label' => '性別',
          // 'data' => $data->getSex(),
          'attr' => [
            'class' => 'form-control',
          ],
          'choices' => [
            '男性' => '男性',
            '女性' => '女性',
            '女装子' => '女装子',
            'ニューハーフ' => 'ニューハーフ',
            '男の娘' => '男の娘',
          ],
          ])
      ->add('age', IntegerType::class, [
          'label' => '年齢',
          // 'data' =>  $data->getAge(),
          'attr' => [
            'class' => 'form-control',
          ],
          ])
      ->add('look', ChoiceType::class, [
            'label' => 'ルックス',
            'attr' => [
              'class' => 'form-control',
            ],
            // 'data' => $data->getLook(),
            'choices' => [
              'sexy系' => 'sexy系',
              '熟女系' => '熟女系',
              '綺麗系' => '綺麗系',
              '可愛い系' => '可愛い系',
              'お嬢系' => 'お嬢系',
              'ギャル系' => 'ギャル系',
              'OL系' => 'OL系',
              '美人系' => '美人系',
              '普通系' => '普通系',
              'ぽちゃ系' => 'ぽちゃ系',
              '初心者系' => '初心者系',
              '腐女子系' => '腐女子系',
              '悪く言われない系' => '悪く言われない系',
              'かっこいい系' => 'かっこいい系',
              '紳士系' => '紳士系',
              '青年系' => '青年系',
              '童貞系' => '童貞系',
              'オタク系' => 'オタク系',
              '文系' => '文系',
              '理系' => '理系',
            ],
            ])
      ->add('area', ChoiceType::class, [
          'label' => 'エリア',
          'attr' => [
            'class' => 'form-control',
          ],
          'choices' => [
            '北海道' => '北海道',
            '東北' => [
              '青森' => '青森',
              '秋田' => '秋田',
              '岩手' => '岩手',
              '宮城' => '宮城',
              '福島' => '福島',
            ],
            '関東' => [
              '群馬' => '群馬',
              '栃木' => '栃木',
              '茨城' => '茨城',
              '埼玉' => '埼玉',
              '千葉' => '千葉',
              '東京' => '東京',
              '神奈川' => '神奈川',
            ],
            '中部' => [
              '新潟' => '新潟',
              '長野' => '長野',
              '山梨' => '山梨',
              '静岡' => '静岡',
              '富山' => '富山',
              '石川' => '石川',
              '福井' => '福井',
              '岐阜' => '岐阜',
              '愛知' => '愛知',
            ],
            '近畿' => [
              '滋賀' => '滋賀',
              '京都' => '京都',
              '三重' => '三重',
              '奈良' => '奈良',
              '和歌山' => '和歌山',
              '大阪' => '大阪',
              '兵庫' => '兵庫',
            ],
            '中国' => [
              '鳥取' => '鳥取',
              '岡山' => '岡山',
              '島根' => '島根',
              '広島' => '広島',
              '山口' => '山口',
            ],
            '四国' => [
              '香川' => '香川',
              '徳島' => '徳島',
              '愛媛' => '愛媛',
              '高知' => '高知',
            ],
            '九州' => [
              '福岡' => '福岡',
              '佐賀' => '佐賀',
              '長崎' => '長崎',
              '大分' => '大分',
              '熊本' => '熊本',
              '宮崎' => '宮崎',
              '鹿児島' => '鹿児島',
            ],
            '沖縄' => '沖縄',
          ],
          ])
      ->add('register', SubmitType::class, [
        'label' => '編集',
        'attr' => [
          'class' => 'btn btn-outline-secondary',
        ],
        ])
      ->getForm();

        
      $form->handleRequest($request);

    if($request->getMethod() == 'POST'){
      
      
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

      $user = $form->getData();
      $manager = $this->getDoctrine()->getManager();
      $manager->flush();


      return $this->render('user/info.html.twig', [
        'title' => 'myInfo',
        'data' => $data,
        'form' => $form->createView(),
        'user_id' => $userId,
        'userData' => $userData,
      ]);
    } else {
      return $this->render('user/info.html.twig', [
        'title' => 'myInfo',
        'data' => $data,
        'form' => $form->createView(),
        'user_id' => $userId,
        'userData' => $userData,
      ]);
    }
  }

}
