<?php
namespace App\Form;

use App\Entity\Contribute;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContributeType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('textarea', TextareaType::class, [
        'label' => '本文',
        'attr' => [
          'class' => 'form-control',
        ]
      ])
      ->add('register', SubmitType::class, [
        'label' => '投稿',
        'attr' => [
          'class' => 'btn btn-outline-secondary',
        ]
        ]);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => Contribute::class,
    ));
  }
}