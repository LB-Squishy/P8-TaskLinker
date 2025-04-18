<?php

namespace App\Form;

use App\Entity\Employe;
use App\Entity\Projet;
use App\Entity\Tache;
use App\Enum\TacheStatut;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TacheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $employesAssignes = $options['employes'];
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre de la tâche',
                'required' => true,
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'required' => true,
            ])
            ->add('deadline', DateType::class, [
                'label' => 'Date',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('statut', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => TacheStatut::cases(),
                'choice_label' => fn(TacheStatut $statut) => $statut->value,
                'choice_value' => fn(?TacheStatut $statut) => $statut?->value,
                'expanded' => false,
                'multiple' => false,
                'attr' => [
                    'class' => 'select2',
                ],
            ])
            // ->add('projet', EntityType::class, [
            //     'class' => Projet::class,
            //     'choice_label' => 'id',
            // ])
            ->add('employe', EntityType::class, [
                'class' => Employe::class,
                'label' => 'Membres',
                'choice_label' => function (Employe $employe) {
                    return $employe->getPrenom() . ' ' . $employe->getNom();
                },
                'choices' => $employesAssignes,
                'multiple' => false,
                'expanded' => false,
                'attr' => [
                    'class' => 'select2',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tache::class,
            'employes' => [],
        ]);
    }
}
