<?php

namespace App\Controller;

use App\Entity\Alumno;
use App\Form\LoginType;
use App\Repository\AlumnoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(Request $request, EntityManagerInterface $entityManager, AlumnoRepository $alumnoRepository): Response
    {
        $alumno = new Alumno(); 
        $form = $this->createForm(LoginType::class, $alumno);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nombre = $alumno->getNombre();
            $dni = $alumno->getDni();

            $login = $entityManager->getRepository(Alumno::class)->findOneBy(['nombre' => $nombre, 'dni' => $dni]);


            if ($login) {
                return $this->redirectToRoute('app_curso_index', [], Response::HTTP_SEE_OTHER);
            } else {
                $this->addFlash('error', 'Credenciales inválidas');
            }
        }

        return $this->render('login/index.html.twig', [
            'form' => $form->createView(), // Pasa la vista del formulario a la plantilla Twig
            'alumno'=> $alumnoRepository->findAll(),
        ]);
    }

}
