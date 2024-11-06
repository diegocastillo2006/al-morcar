<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Libro;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $resultados = null;
        $query = $request->query->get('q');

        if (!empty($query)) {
            $repositorio_libro = $entityManager->getRepository(Libro::class);
            $resultados = $repositorio_libro->buscar($query);
        }

        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
            'resultados' => $resultados
        ]);
    }
}
