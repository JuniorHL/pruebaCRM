<?php

namespace App\Form;
use App\Entity\Curso;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RegistroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Registroalumno', RegistroalumnoType::class)
            //->add('Seleccioncursos', SeleccioncursoType::class)
            ->add('Seleccioncursos', EntityType::class,[
                'class' => Curso::class,
                'choice_label' => 'nombre',
                'multiple' => true,
                'expanded' => true,

            ])
            ->add('Registrar', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
