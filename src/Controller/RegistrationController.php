<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Entity\Profesor;
use App\Entity\Alumno;
use App\Form\AlumnoRegistroFormType;
use App\Form\ProfesorRegistroFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\SecurityBundle\Security;

class RegistrationController extends AbstractController
{

    #[Route('/registro', name: 'app_registro')]
    public function registrarse()
    {
        return $this->render('registro/index.html.twig');
    }

    #[Route('/registro/profesores', name: 'app_registro_profesor')]
    public function registrar_profesor(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, Security $security): Response
    {
        $user = new Usuario();
        $profesor = new Profesor();

        $profesor->setUsuario($user);

        $form = $this->createForm(ProfesorRegistroFormType::class, $profesor);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->render('registro/profesor.html.twig', [
                'registrationForm' => $form,
            ]);
        }

        /** @var string $plainPassword */
        $userEntity = $form->get('usuario');
        $plainPassword = $userEntity->get('plainPassword')->getData();

        $user->setEmail($userEntity->get('email')->getData());

        // encode the plain password
        $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

        $user->setCuentaActivada(false);

        $entityManager->persist($user);
        $entityManager->persist($profesor);
        $entityManager->flush();


        return $this->redirectToRoute('app_dashboard');
    }

    #[Route('/registro/alumnos', name: 'app_registro_alumno')]
    public function registrar_alumno(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, Security $security): Response
    {
        $user = new Usuario();
        $alumno = new Alumno();

        $alumno->setUsuario($user);

        $form = $this->createForm(AlumnoRegistroFormType::class, $alumno);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->render('registro/alumno.html.twig', [
                'registrationForm' => $form,
            ]);
        }

        /** @var string $plainPassword */
        $userEntity = $form->get('usuario');
        $plainPassword = $userEntity->get('plainPassword')->getData();

        $user->setCuentaActivada(false);

        $user->setEmail($userEntity->get('email')->getData());

        // encode the plain password
        $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

        $entityManager->persist($user);
        $entityManager->persist($alumno);
        $entityManager->flush();


        return $this->redirectToRoute('app_dashboard');
    }
}
