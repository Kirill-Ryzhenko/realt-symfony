<?php

namespace App\Form;

use App\Entity\SupportMessage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SupportMessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'data-length' => '60',
                    'class'       => 'characterCounter',
                ],
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'data-length' => '1000',
                    'max'         => 1000,
                    'class'       => 'materialize-textarea characterCounter',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SupportMessage::class,
        ]);
    }
}
