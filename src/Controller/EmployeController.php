<?php

namespace App\Controller;

use App\Repository\EmployeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/employes')]
final class EmployeController extends AbstractController
{
    public function __construct(
        private EmployeRepository $employeRepository,
        private EntityManagerInterface $entityManagerInterface,
    ) {}

    #[Route('', name: 'app_employes', methods: ['GET'])]
    public function index(): Response
    {
        $employes = $this->employeRepository->findAll();

        return $this->render('employe/index.html.twig', [
            'current_page' => 'employes',
            'employes' => $employes,
        ]);
    }
}
