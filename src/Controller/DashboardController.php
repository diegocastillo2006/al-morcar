<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Libro;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_admin');
        }

        $repositorio_libro = $entityManager->getRepository(Libro::class);
        $libros_recientes = $repositorio_libro->recientes();

        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'librosRecientes' => $libros_recientes
        ]);
    }
}
