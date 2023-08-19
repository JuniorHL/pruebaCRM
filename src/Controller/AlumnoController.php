<?php

namespace App\Controller;
use App\Entity\Alumno;
use App\Entity\Matricula;
use App\Entity\Curso;
use App\Form\AlumnoType;
use App\Repository\AlumnoRepository;
use App\Repository\CursoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

class AlumnoController extends AbstractController
{
    #[Route('/alumno', name: 'app_alumno')]
    public function index(Request $request, EntityManagerInterface $entityManager, AlumnoRepository $alumnoRepository, CursoRepository $cursoRepository, LoggerInterface $logger): Response
    {
        $alumno = new Alumno();
        $form = $this->createForm(AlumnoType::class,$alumno);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
           
            $entityManager->persist($alumno);
            $entityManager->flush();

            //obtener cursos y generar registros en Matricula
            $cursoselect = $request->request->get('cursosSeleccionados[]');
            $cursoselect = explode(',', $cursoselect);
           
            foreach($cursoselect as $cursoId){
                $curso = $entityManager->getRepository(Curso::class)->find($cursoId);
                if($curso){
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
            'form' => $form,
            'alumnos'=> $alumnoRepository->findAll(),
            'cursos'=> $cursoRepository->findAll()
        ]);
    }
}
