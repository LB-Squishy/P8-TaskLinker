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

    #[Route('/{projetId}/new', name: 'app_tache_new', methods: ['GET', 'POST'])]
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

    #[Route('/{tacheId}/delete', name: 'app_tache_delete', methods: ['GET', 'POST'])]
    public function deleteTache(int $tacheId): Response
    {
        $tache = $this->tacheRepository->find($tacheId);
        if (!$tache) {
            $this->addFlash('error', 'Cette tâche n\'existe pas.');
            return $this->redirectToRoute('app_accueil');
        }

        $projet = $tache->getProjet();
        $this->entityManagerInterface->remove($tache);
        $this->entityManagerInterface->flush();
        $this->addFlash('success', 'La tâche a été supprimée avec succès.');

        return $this->redirectToRoute('app_projet_show', ['id' => $projet->getId()]);
    }

    #[Route('/{tacheId}/edit', name: 'app_tache_edit', methods: ['GET', 'POST'])]
    public function editTache(int $tacheId, Request $request): Response
    {
        $tache = $this->tacheRepository->find($tacheId);
        if (!$tache) {
            $this->addFlash('error', 'Cette tâche n\'existe pas.');
            return $this->redirectToRoute('app_accueil');
        }

        $projet = $tache->getProjet();
        $employes = $projet->getEmploye();
        $form = $this->createForm(TacheType::class, $tache, [
            'employes' => $employes,
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $tache = $form->getData();
            $this->entityManagerInterface->persist($tache);
            $this->entityManagerInterface->flush();
            $this->addFlash('success', 'La tâche a été modifié avec succès.');
            return $this->redirectToRoute('app_projet_show', ['id' => $projet->getId()]);
        }

        return $this->render('tache/edit.html.twig', [
            'current_page' => 'tache.name',
            'form' => $form,
            'tache' => $tache,
        ]);
    }
}
