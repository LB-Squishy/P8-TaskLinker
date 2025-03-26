<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Creneau;
use App\Entity\Employe;
use App\Entity\Projet;
use App\Entity\Statut;
use App\Entity\Tache;
use App\Entity\Tag;

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
                ->setNom($faker->word())
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
                ->setRole($faker->numberBetween(0, 1))
                ->setContrat($faker->randomElement(['CDI', 'CDD', 'Stage']))
                ->setEmail($faker->email())
                ->setPassword($faker->password())
                ->setActif($faker->boolean(80))
                ->setDateArrivee($faker->dateTimeBetween('-5 years', 'now'));
            $manager->persist($employe);
            $employes[] = $employe;

            // Ajout des Employes aux Projets
            $randomProjets = $faker->randomElements($projets, $faker->numberBetween(1, 3));
            foreach ($randomProjets as $projet) {
                $employe->addProjet($projet);
            }
        }

        // Création des Statuts
        $statuts = [];
        $libellesStatuts = ['En cours', 'À faire', 'Terminé'];
        foreach ($projets as $projet) {
            foreach ($libellesStatuts as $libelle) {
                $statut = new Statut();
                $statut
                    ->setLibelle($libelle)
                    ->setProjet($projet);
                $manager->persist($statut);
                $statuts[] = $statut;
            }
        }

        // Création des Tags
        $tags = [];
        for ($i = 0; $i < 5; $i++) {
            $tag = new Tag();
            $tag
                ->setLibelle($faker->word())
                ->setProjet($faker->randomElement($projets));
            $manager->persist($tag);
            $tags[] = $tag;
        }

        // Création des Taches
        $taches = [];
        for ($i = 0; $i < 20; $i++) {
            $tache = new Tache();
            $tache
                ->setTitre($faker->sentence(3))
                ->setDescription($faker->paragraph())
                ->setDeadline($faker->dateTimeBetween('now', '+5 years'))
                ->setProjet($faker->randomElement($projets))
                ->setStatut($faker->randomElement($statuts))
                ->setEmploye($faker->randomElement($employes));
            $manager->persist($tache);
            $taches[] = $tache;

            // Ajout des Tags aux Taches
            $randomTags = $faker->randomElements($tags, $faker->numberBetween(1, 3));
            foreach ($randomTags as $tag) {
                $tache->addTag($tag);
            }
        }

        // Création des Creneaux
        for ($i = 0; $i < 20; $i++) {
            $creneau = new Creneau();
            $creneau
                ->setDateDebut($faker->dateTimeBetween('-1 years', 'now'))
                ->setDateFin($faker->dateTimeBetween('now', '+1 years'))
                ->setEmploye($faker->randomElement($employes))
                ->setTache($faker->randomElement($taches));
            $manager->persist($creneau);
        }

        $manager->flush();
    }
}
