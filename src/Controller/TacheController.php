<?php

namespace App\Controller;

use App\Entity\Tache;
use App\Form\TacheType;
use App\Repository\ProjetRepository;
use App\Repository\TacheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tache')]
final class TacheController extends AbstractController
{
    public function __construct(
        private TacheRepository $tacheRepository,
        private ProjetRepository $projetRepository,
        private EntityManagerInterface $entityManagerInterface,
    ) {}

    #[Route('/new/{projetId}', name: 'app_tache_new', methods: ['GET', 'POST'])]
    public function newTache(int $projetId, Request $request): Response
    {
        $projet = $this->projetRepository->find($projetId);
        if (!$projet) {
            $this->addFlash('error', 'Ce projet n\'existe pas.');
            return $this->redirectToRoute('app_accueil');
        }

        $employes = $projet->getEmploye();

        $tache = new Tache();
        $form = $this->createForm(TacheType::class, $tache, [
            'employes' => $employes,
        ]);

        $tache->setProjet($projet);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $tache = $form->getData();
            $this->entityManagerInterface->persist($tache);
            $this->entityManagerInterface->flush();
            $this->addFlash('success', 'La tâche a été créée avec succès.');
            return $this->redirectToRoute('app_projet_show', ['id' => $projetId]);
        }
        return $this->render('tache/new.html.twig', [
            'current_page' => 'tache.name',
            'form' => $form,
            'projetId' => $projetId,
            'projet' => $projet
        ]);
    }

    // #[Route('/{id}', name: 'app_projet_show', methods: ['GET'])]
    // public function index(int $id): Response
    // {
    //     $projet = $this->projetRepository->find($id);
    //     if (!$projet) {
    //         $this->addFlash('error', 'Ce projet n\'existe pas.');
    //         return $this->redirectToRoute('app_accueil');
    //     }
    //     $taches = $projet->getTaches();

    //     return $this->render('projet/show.html.twig', [
    //         'current_page' => 'projet.name',
    //         'projet' => $projet,
    //         'taches' => $taches,
    //         'statuts' => TacheStatut::cases(),
    //     ]);
    // }

    // #[Route('/{id}/delete', name: 'app_projet_delete', methods: ['GET', 'POST'])]
    // public function deleteProjet(int $id): Response
    // {
    //     $projet = $this->projetRepository->find($id);

    //     if (!$projet) {
    //         $this->addFlash('error', 'Ce projet n\'existe pas.');
    //         return $this->redirectToRoute('app_accueil');
    //     }

    //     $projet->setArchive(true);
    //     $this->entityManagerInterface->persist($projet);
    //     $this->entityManagerInterface->flush();
    //     $this->addFlash('success', 'Le projet a été archivé avec succès.');

    //     return $this->redirectToRoute('app_accueil');
    // }

    // #[Route('/{id}/edit', name: 'app_projet_edit', methods: ['GET', 'POST'])]
    // public function editProjet(int $id, Request $request): Response
    // {
    //     $projet = $this->projetRepository->find($id);

    //     if (!$projet) {
    //         $this->addFlash('error', 'Ce projet n\'existe pas.');
    //         return $this->redirectToRoute('app_accueil');
    //     }

    //     $form = $this->createForm(ProjetType::class, $projet);

    //     $form->handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $projet = $form->getData();
    //         $this->entityManagerInterface->persist($projet);
    //         $this->entityManagerInterface->flush();
    //         $this->addFlash('success', 'Le projet a été modifié avec succès.');
    //         return $this->redirectToRoute('app_projet_show', ['id' => $projet->getId()]);
    //     }
    //     return $this->render('projet/new.html.twig', [
    //         'current_page' => 'projet.name',
    //         'form' => $form,
    //     ]);
    // }
}
