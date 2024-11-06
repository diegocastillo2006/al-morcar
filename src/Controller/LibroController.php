<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Libro;
use Doctrine\Common\Collections\Criteria;

class LibroController extends AbstractController
{
    #[Route('/libros/{id}', name: 'libro_ver')]
    public function show(Libro $libro): Response
    {
        $usuario = $this->getUser();
        $criteria = Criteria::create();
        $criteria->where(Criteria::expr()->eq('libro', $libro));

        $prestamo_activo = false;
      
        if($usuario && count($usuario->getPrestamos()->matching($criteria)) > 0) {
            $prestamo_activo = true;
        }

        return $this->render('libro/index.html.twig', [
            'controller_name' => 'DashboardController',
            'libro' => $libro,
            'prestamo_activo' => $prestamo_activo
        ]);
    }

    #[Route('admin/libros/{id}/editar', name: 'libro_editar')]
    public function editar(Request $request, Libro $libro, EntityManagerInterface $entityManager): Response
    {
        $libro->setTitulo($request->get('titulo'));
        $libro->setAutor($request->get('autor'));
        $libro->setGenero($request->get('genero'));
        $libro->setEditorial($request->get('editorial'));
        $libro->setNumPag($request->get('num_pag'));
        $libro->setIsbn($request->get('isbn'));

        $entityManager->flush();

        return $this->redirectToRoute('app_admin_libros');
    }

    #[Route('admin/libros/{id}/eliminar', name: 'libro_eliminar')]
    public function eliminar(Libro $libro, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($libro);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_libros');
    }
}
