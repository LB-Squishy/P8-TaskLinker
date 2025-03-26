<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EmployeController extends AbstractController
{
    #[Route('/employes', name: 'app_employes')]
    public function index(): Response
    {
        return $this->render('employe/index.html.twig', [
            'controller_name' => 'EmployeController',
            'current_page' => 'employes',
        ]);
    }
}
