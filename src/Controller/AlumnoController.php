<?php

namespace App\Controller;
use App\Entity\Alumno;
use App\Entity\Matricula;
use App\Entity\Curso;
use App\Form\AlumnoType;
use App\Repository\AlumnoRepository;
use App\Repository\CursoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AlumnoController extends AbstractController
{
    #[Route('/alumno', name: 'app_alumno')]
    public function index(Request $request, EntityManagerInterface $entityManager, AlumnoRepository $alumnoRepository, CursoRepository $cursoRepository, LoggerInterface $logger): Response
    {
        $alumno = new Alumno();
        $form = $this->createForm(AlumnoType::class, $alumno,[
            'cursos' => $cursoRepository-> findAll(),
        ]);

        // Obtener cursos desde el repositorio
        $cursos = $cursoRepository->findAll();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... Código para persistir el alumno y crear registros en Matricula
            $entityManager->persist($alumno);

            $cursosSeleccionados = $form->get('cursosSeleccionados')->getData();
            foreach ($cursosSeleccionados as $cursoId) {
                $curso = $cursoRepository->find($cursoId);
                if ($curso) {
                    dump('Creando matrícula para el curso ' . $curso->getNombre());
                    $matricula = new Matricula();
                    $matricula->setIdAlumno($alumno);
                    $matricula->setIdCurso($curso);
                    $entityManager->persist($matricula);
                }
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_alumno');
        }
        return $this->render('alumno/index.html.twig', [
            'form' => $form->createView(),
            'alumnos' => $alumnoRepository->findAll(),
            'cursos' => $cursos,
        ]);
    }
}
