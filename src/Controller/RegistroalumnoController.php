<?php

namespace App\Controller;

use App\Entity\Matricula;
use App\Entity\Alumno;
use App\Entity\Curso;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RegistroalumnoType;
use App\Form\RegistroType;
use App\Form\SeleccioncursoType;
use App\Repository\AlumnoRepository;
use App\Repository\CursoRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class RegistroalumnoController extends AbstractController
{
    #[Route('/registroalumno', name: 'app_registroalumno')]
    public function index(Request $request, EntityManagerInterface $entityManager, AlumnoRepository $alumnoRepository, CursoRepository $cursoRepository): Response
    {
        $form = $this->createForm(RegistroType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Obtener datos del formulario
            $data = $form->getData();
            $alumno = $data['Registroalumno'];
            // Array de IDs de cursos
        
            // Persistir alumno y matrícula
            $entityManager->persist($alumno);
            $cursoIds = $data['Seleccioncursos'];
            
            foreach ($cursoIds as $cursoId) {
                $curso = $cursoRepository->find($cursoId);
                
                if ($curso) {
                    $matricula = new Matricula();
                    $matricula->setIdAlumno($alumno);
                    $matricula->setIdCurso($curso); // Asignar el curso a la matrícula
                    $entityManager->persist($matricula);
                    } 
                    
                }
                $entityManager->flush();
        
                return $this->redirectToRoute('app_registroalumno'); 
            }
        
        return $this->render('registroalumno/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }}
        



