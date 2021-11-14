<?php

namespace App\Form;

use App\Entity\Announcement;
use phpDocumentor\Reflection\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterAnnouncementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('apartment_size', ChoiceType::class, [
                'label'        => 'Количество комнат',
                'choices'      => [
                    'Не выбрано'   => null,
                    'Комната'      => 'Комната',
                    '1-к квартира' => '1-к квартира',
                    '2-к квартира' => '2-к квартира',
                    '3-к квартира' => '3-к квартира',
                    '4-к квартира' => '4-к квартира',
                    '5-к квартира' => '5-к квартира',
                    '6-к квартира' => '6-к квартира',
                ],
                'choice_attr'  => function ($key) {
                    return ($key === null) ? ['disabled' => 'disabled'] : [];
                },
            ])
            ->add('due_date', ChoiceType::class, [
                'label'       => 'Срок аренды',
                'choices'     => [
                    'Договорная' => null,
                    'Сутки/Часы' => 'Сутки/Часы',
                    'Месяц'      => 'Месяц',
                    '2 месяца'   => '2 месяца',
                    '3 месяца'   => '3 месяца',
                    'Полгода'    => 'Полгода',
                    'Год'        => 'Год',
                    'Длительный' => 'Длительный',
                ],
                'choice_attr' => function ($key) {
                    return ($key === null) ? ['disabled' => 'disabled'] : [];
                },
            ])
            ->add('type_house', ChoiceType::class, [
                'label'       => 'Тип дома',
                'choices'     => [
                    'Не выбрано'       => null,
                    'Панельный'        => 'Панельный',
                    'Кирпичный'        => 'Кирпичный',
                    'Блок-комнаты'     => 'Блок-комнаты',
                    'Монолитный'       => 'Монолитный',
                    'Каркасно-блочный' => 'Каркасно-блочный',
                ],
                'choice_attr' => function ($key) {
                    return ($key === null) ? ['disabled' => 'disabled'] : [];
                },
            ])
            ->add('balcony', ChoiceType::class, [
                'label'       => 'Балкон',
                'choices'     => [
                    'Не выбрано'          => null,
                    'Нет'                 => 'Нет',
                    'Балкон'              => 'Балкон',
                    'Лоджия'              => 'Лоджия',
                    'Балкон застекленный' => 'Балкон застекленный',
                ],
                'choice_attr' => function ($key) {
                    return ($key === null) ? ['disabled' => 'disabled'] : [];
                },
            ])
            ->add('sort', ChoiceType::class, [
                'label'       => false,
                'choices'     => [
                    'Не выбрано' => null,
                    'price DESC' => 'От дорогих к дешевым',
                    'price ASC'  => 'От дешевых к дорогим',
//                    'price ASC'  => 'Старые',
//                    'price DESC' => 'Новые',
                ],
                'choice_attr' => function ($key) {
                    return ($key === null) ? ['disabled' => 'disabled'] : [];
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'typeAnnouncement' => false,
        ]);
    }
}
