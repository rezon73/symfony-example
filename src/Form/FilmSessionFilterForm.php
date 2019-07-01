<?php
namespace App\Form;

use App\Entity\FilmSessionFilter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FilmSessionFilterForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fromDate', DateTimeType::class, [
                'label' => false,
                'attr' => [
                    'class'       => 'form-control film-session-date-block',
                    'placeholder' => 'От',
                ],
            ])
            ->add('toDate', DateTimeType::class, [
                'label' => false,
                'attr' => [
                    'class'       => 'form-control film-session-date-block',
                    'placeholder' => 'До',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Искать',
                'attr' => [
                    'class' => 'btn btn-primary btn-lg btn-block',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FilmSessionFilter::class
        ]);
    }
}
