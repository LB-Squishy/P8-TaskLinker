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

            // Ajout des Employes aux Projets
            $randomProjets = $faker->randomElements($projets, $faker->numberBetween(1, 3));
            foreach ($randomProjets as $projet) {
                $employe->addProjet($projet);
            }
        }

        // Création des Taches
        for ($i = 0; $i < 20; $i++) {
            $tache = new Tache();
            $tache
                ->setTitre($faker->sentence(3))
                ->setDescription($faker->paragraph())
                ->setDeadline($faker->dateTimeBetween('now', '+5 years'))
                ->setStatut($faker->randomElement([TacheStatut::TO_DO, TacheStatut::DOING, TacheStatut::DONE]))
                ->setProjet($faker->randomElement($projets))
                ->setEmploye($faker->randomElement($employes));
            $manager->persist($tache);
        }

        $manager->flush();
    }
}
