<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Employe;
use App\Entity\Projet;
use App\Entity\Tache;
use App\Enum\TacheStatut;

use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Création des Projets
        $projets = [];
        for ($i = 0; $i < 10; $i++) {
            $projet = new Projet();
            $projet
                ->setTitre($faker->sentence(2))
                ->setArchive($faker->boolean(20));
            $manager->persist($projet);
            $projets[] = $projet;
        }

        // Création des Employes
        $employes = [];
        for ($i = 0; $i < 10; $i++) {
            $employe = new Employe();
            $employe
                ->setNom($faker->lastName())
                ->setPrenom($faker->firstName())
                ->setEmail($faker->email())
                ->setDateEntree($faker->dateTimeBetween('-5 years', 'now'))
                ->setStatut($faker->randomElement(['CDI', 'CDD', 'Stage', 'Alternance']))
                ->setActif($faker->boolean(80));
            $manager->persist($employe);
            $employes[] = $employe;
        }

        // Assignation des Employes aux Projets (au moins 2 employés par projet)
        foreach ($projets as $projet) {
            $assignedEmployes = $faker->randomElements($employes, $faker->numberBetween(2, 5));
            foreach ($assignedEmployes as $employe) {
                $projet->addEmploye($employe);
                $employe->addProjet($projet);
            }
        }

        // Création des Taches (au moins une tâche par statut pour chaque projet)
        foreach ($projets as $projet) {
            $projectEmployes = $projet->getEmploye()->toArray(); // Employés assignés au projet

            foreach (TacheStatut::cases() as $statut) {
                $tache = new Tache();
                $tache
                    ->setTitre($faker->sentence(3))
                    ->setDescription($faker->paragraph())
                    ->setDeadline($faker->dateTimeBetween('now', '+5 years'))
                    ->setStatut($statut)
                    ->setProjet($projet)
                    ->setEmploye($faker->randomElement($projectEmployes)); // Employé assigné au projet
                $manager->persist($tache);
            }

            // Ajout de tâches supplémentaires (optionnel)
            for ($i = 0; $i < $faker->numberBetween(1, 5); $i++) {
                $tache = new Tache();
                $tache
                    ->setTitre($faker->sentence(3))
                    ->setDescription($faker->paragraph())
                    ->setDeadline($faker->dateTimeBetween('now', '+5 years'))
                    ->setStatut($faker->randomElement(TacheStatut::cases()))
                    ->setProjet($projet)
                    ->setEmploye($faker->randomElement($projectEmployes)); // Employé assigné au projet
                $manager->persist($tache);
            }
        }

        $manager->flush();
    }
}
