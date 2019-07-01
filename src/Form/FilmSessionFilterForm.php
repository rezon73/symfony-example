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
                'label' => 'Начальная дата',
                'attr' => [
                    'class'       => 'form-control film-session-date-block',
                    'placeholder' => 'От',
                ],
                'data'        => new \DateTime(),
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
            ])
            ->add('toDate', DateTimeType::class, [
                'label' => 'Конечная дата',
                'attr' => [
                    'class'       => 'form-control film-session-date-block',
                    'placeholder' => 'До',
                ],
                'data'        => new \DateTime('+2 day'),
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Показать',
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
