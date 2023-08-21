<?php

namespace App\Form;

use App\Entity\Matricula;
use App\Entity\Curso;
use App\Entity\Alumno;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeleccioncursoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
            ->add('idCurso', EntityType::class,[
                'class' => Curso::class,
                'choice_label' => 'nombre',
                'multiple' => false,
                'expanded' => true,

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Matricula::class,
        ]);
    }
}
