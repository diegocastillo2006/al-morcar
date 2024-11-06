<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Libro;
use App\Entity\Prestamo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class PerfilController extends AbstractController
{
    #[Route('/perfil/prestamos', name: 'app_perfil_prestamos')]
    public function prestamos(EntityManagerInterface $entityManager, Security $security): Response
    {
        $repositorio_prestamo = $entityManager->getRepository(Prestamo::class);

        $prestamos = $repositorio_prestamo
        ->obtenerPrestamosUsuario($security->getUser());

        return $this->render('perfil/prestamos.html.twig', [
            'controller_name' => 'PerfilController',
            'prestamos' => $prestamos
        ]);
    }
}
