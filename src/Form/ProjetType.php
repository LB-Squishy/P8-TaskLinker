<?php

namespace App\Form;

use App\Entity\Employe;
use App\Entity\Projet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $employesActifs = $options['employes'];
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre du projet',
                'required' => true,
            ])
            // ->add('archive', CheckboxType::class, [
            //     'label' => 'Archiver',
            // ])
            ->add('employe', EntityType::class, [
                'class' => Employe::class,
                'label' => 'Inviter des membres',
                'choices' => $employesActifs,
                'choice_label' => function (Employe $employe) {
                    return $employe->getPrenom() . ' ' . $employe->getNom();
                },
                'multiple' => true,
                'expanded' => false,
                'required' => false,
                'attr' => [
                    'class' => 'select2',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
            'employes' => [],
        ]);
    }
}
