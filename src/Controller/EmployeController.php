<?php

namespace App\Controller;

use App\Form\EmployeType;
use App\Repository\EmployeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

final class EmployeController extends AbstractController
{
    public function __construct(
        private EmployeRepository $employeRepository,
        private EntityManagerInterface $entityManagerInterface,
    ) {}

    #[Route('/employes', name: 'app_employes', methods: ['GET'])]
    public function index(): Response
    {
        $employes = $this->employeRepository->findAllIsActif();

        return $this->render('employe/index.html.twig', [
            'current_page' => 'employes',
            'employes' => $employes,
        ]);
    }

    #[Route('/employe/{id}/delete', name: 'app_employe_delete', methods: ['GET', 'POST'])]
    public function deleteEmploye(int $id): Response
    {
        $employe = $this->employeRepository->find($id);
        if (!$employe) {
            $this->addFlash('error', 'Cet employé n\'existe pas.');
            return $this->redirectToRoute('app_accueil');
        }

        $employe->setActif(false);

        foreach ($employe->getProjets() as $projet) {
            $projet->removeEmploye($employe);
        }
        foreach ($employe->getTaches() as $tache) {
            $tache->setEmploye(null);
        }

        $this->entityManagerInterface->persist($employe);
        $this->entityManagerInterface->flush();
        $this->addFlash('success', 'L\'employé a été désactivé avec succès.');

        return $this->redirectToRoute('app_employes');
    }

    #[Route('/employe/{id}/edit', name: 'app_employe_edit', methods: ['GET', 'POST'])]
    public function editEmploye(int $id, Request $request): Response
    {
        $employe = $this->employeRepository->find($id);
        if (!$employe) {
            $this->addFlash('error', 'Cet employé n\'existe pas.');
            return $this->redirectToRoute('app_accueil');
        }

        $form = $this->createForm(EmployeType::class, $employe);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $employe = $form->getData();
            $this->entityManagerInterface->persist($employe);
            $this->entityManagerInterface->flush();
            $this->addFlash('success', 'L\'employé a été modifié avec succès.');
            return $this->redirectToRoute('app_employe_edit', ['id' => $employe->getId()]);
        }

        return $this->render('employe/edit.html.twig', [
            'current_page' => 'employes',
            'employe' => $employe,
            'form' => $form,
        ]);
    }
}
