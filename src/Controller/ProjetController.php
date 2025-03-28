<?php

namespace App\Controller;

use App\Enum\TacheStatut;
use App\Repository\ProjetRepository;
use App\Repository\TacheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/projet')]
final class ProjetController extends AbstractController
{
    public function __construct(
        private ProjetRepository $projetRepository,
        private TacheRepository $tacheRepository,
        private EntityManagerInterface $entityManagerInterface,
    ) {}

    #[Route('/{id}', name: 'app_projet_show', methods: ['GET'])]
    public function index(int $id): Response
    {
        $projet = $this->projetRepository->find($id);
        if (!$projet) {
            return $this->redirectToRoute('app_accueil');
        }
        // if ($projet->isArchive()) {
        //     return $this->redirectToRoute('app_accueil');
        // }
        $taches = $projet->getTaches();

        return $this->render('projet/show.html.twig', [
            'current_page' => 'projet.name',
            'projet' => $projet,
            'taches' => $taches,
            'statuts' => TacheStatut::cases(),
        ]);
    }
}
