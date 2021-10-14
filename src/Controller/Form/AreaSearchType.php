<?php
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AreaSearchType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('area', ChoiceType::class, [
          'label' => 'エリア',
          'attr' => [
            'class' => 'form-control',
          ],
          'placeholder' => 'Area',
          'choices' => [
            '全エリア' => '全エリア',
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
            
          ]
          ])
      
      ->add('register', SubmitType::class, [
        'label' => 'Search',
        'attr' => [
          'class' => 'btn btn-outline-secondary',
        ]
        ]);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => User::class,
    ));
  }
}