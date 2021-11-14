<?php

namespace App\Form;

use App\Entity\Announcement;
use App\Entity\Properties;
use App\Repository\PropertiesRepository;
use phpDocumentor\Reflection\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnouncementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('street', TextType::class, [
                'required' => true,
                'attr'     => [
                    'class'        => 'autocomplete',
                    'autocomplete' => 'off',
                ],
                'label'    => 'Улица',
            ])
            ->add('total_area', TextType::class, [
                'required' => true,
                'attr'     => [
                    'class' => 'form-control validate',
                    'min'   => '0',
                    'step'  => '0.01',
                ],
            ])
            ->add('living_area', TextType::class, [
                'required' => true,
                'attr'     => [
                    'class' => 'form-control validate',
                    'min'   => '0',
                    'step'  => '0.01',
                ],
            ])
            ->add('kitchen_area', TextType::class, [
                'required' => true,
                'attr'     => [
                    'class' => 'form-control validate',
                    'min'   => '0',
                    'step'  => '0.01',
                ],
            ])
            ->add('floor', TextType::class, [
                'required' => true,
                'attr'     => [
                    'class' => 'form-control validate',
                    'min'   => '1',
                    'step'  => '1',
                ],
            ])
            ->add('countFloor', TextType::class, [
                'required' => true,
                'attr'     => [
                    'class' => 'form-control validate',
                    'min'   => '1',
                    'step'  => '1',
                ],
            ])
            ->add('idBalcony', EntityType::class, [
                'class'         => Properties::class,
                'query_builder' => function (PropertiesRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->andWhere('p.type = :val')
                        ->setParameter('val', 'Балкон')
                        ->orderBy('p.id', 'ASC')
                        ;
                },
                'choice_label'  => 'title',
                'placeholder'   => 'Не выбрано',
                'empty_data'    => null,
                'required'      => false,
            ])
            ->add('idTypeHouse', EntityType::class, [
                'class'         => Properties::class,
                'query_builder' => function (PropertiesRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->andWhere('p.type = :val')
                        ->setParameter('val', 'Тип дома')
                        ->orderBy('p.id', 'ASC')
                        ;
                },
                'choice_label'  => 'title',
                'placeholder'   => 'Не выбрано',
                'empty_data'    => null,
                'required'      => false,
            ])
            ->add('idApartmentSize', EntityType::class, [
                'class'         => Properties::class,
                'query_builder' => function (PropertiesRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->andWhere('p.type = :val')
                        ->setParameter('val', 'Размер квартиры')
                        ->orderBy('p.id', 'ASC')
                        ;
                },
                'choice_label'  => 'title',
                'placeholder'   => 'Не выбрано',
                'empty_data'    => null,
                'required'      => false,
            ])
            ->add('idDueDate', EntityType::class, [
                'class'         => Properties::class,
                'query_builder' => function (PropertiesRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->andWhere('p.type = :val')
                        ->setParameter('val', 'Срок аренды')
                        ->orderBy('p.id', 'ASC')
                        ;
                },
                'choice_label'  => 'title',
                'placeholder'   => 'Не выбрано',
                'empty_data'    => null,
                'required'      => false,
            ])
            ->add('idOwnership', EntityType::class, [
                'class'         => Properties::class,
                'query_builder' => function (PropertiesRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->andWhere('p.type = :val')
                        ->setParameter('val', 'Собственность')
                        ->orderBy('p.id', 'ASC')
                        ;
                },
                'choice_label'  => 'title',
                'placeholder'   => 'Не выбрано',
                'empty_data'    => null,
                'required'      => false,
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'attr'     => [
                    'class' => 'materialize-textarea',
                ],
            ])
            ->add('price', TextType::class, [
                'attr' => [
                    'class' => 'form-control validate',
                    'min'   => '0',
                    'step'  => '0.01',
                ],
                'help' => 'Пустое значение или 0 является договорной',
            ])
            ->add('photos', FileType::class, [
                'label'      => 'Фотографии',
                'mapped'     => false,
                'required'   => false,
                'multiple'   => true,
                'label_attr' => [
                    'style' => 'color:#fff',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'       => Announcement::class,
            'typeAnnouncement' => false,
        ]);
    }
}
