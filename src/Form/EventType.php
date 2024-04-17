<?php

namespace App\Form;

use App\Entity\Comedian;
use App\Entity\ComedyClub;
use App\Entity\Establishment;
use App\Entity\Event;
use App\Entity\Image;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', null, [
                'widget' => 'single_text',
            ])
            ->add('name')
            ->add('description')
            ->add('price')
            ->add('duration')
            ->add('location', EntityType::class, [
                'class' => Establishment::class,
                'choice_label' => 'name',
            ])
            ->add('comedians', EntityType::class, [
                'class' => Comedian::class,
                'choice_label' => 'name',
                'multiple' => true,
            ])

            ->add('comedyClub', EntityType::class, [
                'class' => ComedyClub::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
