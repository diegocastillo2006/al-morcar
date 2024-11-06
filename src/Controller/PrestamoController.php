<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Libro;
use App\Entity\Prestamo;
use App\Form\PrestamoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class PrestamoController extends AbstractController
{
    #[Route('/prestamo/{id}', name: 'app_prestamo')]
    public function index(Request $request, Libro $libro, EntityManagerInterface $entityManager, Security $security): Response
    {
        if (!$libro->isDisponible()) {
            return $this->redirectToRoute('libro_ver', ['id' => $libro->getId()]);
        }

        $prestamo = new Prestamo();

        $form = $this->createForm(PrestamoType::class, $prestamo);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->render('prestamo/index.html.twig', [
                'controller_name' => 'PrestamoController',
                'form' => $form,
                'libro' => $libro
            ]);
        }

        $prestamo->setLibro($libro);
        $prestamo->setUsuario($security->getUser());

        $prestamo->setEstado('En proceso');

        $usuario = $this->getUser();

        if ($usuario->getPrestamos()->contains($prestamo)) {
            $this->redirectToRoute('app_perfil_prestamos', [
                'errors' => ['El prestamo ya existe']
            ]);
        }

        $entityManager->persist($prestamo);

        $entityManager->flush();

        return $this->redirectToRoute('app_perfil_prestamos');
    }

    #[Route('/prestamo/admin/{id}/aprobar', name: 'app_prestamo_aprobar')]
    public function aprobar_prestamo(Prestamo $prestamo, EntityManagerInterface $entityManager): Response
    {
        $prestamo->getLibro()->setDisponible(false);

        $prestamo->setEstado('Activo');
        $entityManager->flush();

        return $this->redirectToRoute('app_admin');
    }

    #[Route('prestamo/admin/{id}/rechazar', name: 'app_prestamo_rechazar')]
    public function rechazar_prestamo(Prestamo $prestamo, EntityManagerInterface $entityManager): Response
    {
        $prestamo->getLibro()->setDisponible(true);

        $entityManager->remove($prestamo);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin');
    }
}
