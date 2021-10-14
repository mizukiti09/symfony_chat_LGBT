<?php
namespace App\Form;

use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MessageType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('message', TextareaType::class, [
        'attr' => [
          'class' => 'msg-textarea',
        ]
        ])
      ->add('register', SubmitType::class, [
        'label' => '送信',
        'attr' => [
          'class' => 'btn btn-outline-secondary',
        ]
        ]);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => Message::class,
    ));
  }
}