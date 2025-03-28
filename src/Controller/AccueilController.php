<?php

namespace App\Controller;

use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccueilController extends AbstractController
{
    public function __construct(
        private ProjetRepository $projetRepository,
    ) {}

    #[Route('/', name: 'app_accueil', methods: ['GET'])]
    public function index(): Response
    {
        $projets = $this->projetRepository->findAll();

        return $this->render('accueil/index.html.twig', [
            'current_page' => 'accueil',
            'projets' => $projets,
        ]);
    }
}
