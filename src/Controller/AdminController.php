<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Usuario;
use App\Entity\Libro;
use App\Entity\Prestamo;
use App\Form\LibroType;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function dashboard(Request $request, EntityManagerInterface $entityManager): Response
    {
        $repositorio_usuario = $entityManager->getRepository(Usuario::class);
        $cuentas_no_activadas = $repositorio_usuario->obtenerCuentasNoActivadas();

        $repositorio_prestamo = $entityManager->getRepository(Prestamo::class);

        $prestamos_activos = $repositorio_prestamo->activos();
        $prestamos_proceso = $repositorio_prestamo->enProceso();
        $prestamos_atrasados = $repositorio_prestamo->atrasados();

        $libro = new Libro();
        $form = $this->createForm(LibroType::class, $libro);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->render('admin/dashboard.html.twig', [
                'controller_name' => 'AdminController',
                'libroForm' => $form,
                'cuentasNoActivadas' => $cuentas_no_activadas,
                'prestamos_activos' => $prestamos_activos,
                'prestamos_proceso' => $prestamos_proceso,
                'prestamos_atrasados' => $prestamos_atrasados
            ]);
        }

        $entityManager->persist($libro);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin');
    }

    #[Route('/admin/libros', name: 'app_admin_libros')]
    public function gestion_libros(EntityManagerInterface $entityManager): Response
    {
        $repositorio_libro = $entityManager->getRepository(Libro::class);

        $libros = $repositorio_libro->recientes();

        return $this->render('admin/libros.html.twig', [
            'controller_name' => 'AdminController',
            'libros' => $libros
        ]);
    }

    #[Route('/admin/{id}/aprobar', name: 'app_admin_aprobar')]
    public function aprobar_usuario(Usuario $usuario, EntityManagerInterface $entityManager): Response
    {
        $usuario->setCuentaActivada(true);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin');
    }

    #[Route('/admin/{id}/rechazar', name: 'app_admin_rechazar')]
    public function rechazar_usuario(Usuario $usuario, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($usuario);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin');
    }
}
