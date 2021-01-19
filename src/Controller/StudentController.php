<?php

namespace App\Controller;

use App\Entity\Club;
use App\Form\SearchStudentByClubType;
use App\Form\SearchStudentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Student;
use App\Form\StudentType;
class StudentController extends AbstractController
{
    /**
     * @Route("/student", name="index")
     */
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }

    /**
     * @Route("/listStudent", name="student")
     */
    public function listStudent()
    {   $students = $this->getDoctrine()
                         ->getRepository(Student::class)
                         ->findStudentsByOrder();
        return $this->render('student/list.html.twig', ["students" => $students]);
    }

    /**
     * @Route("/add", name="addStudent")
     */
    public function addStudent(Request $request)
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
       // $form->add('ajouter',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();
            return $this->redirectToRoute('student');
        }
        return $this->render("student/add.html.twig",array('form'=>$form->createView()));
    }
    /**
     * @Route("/show/{id}", name="showStudent")
     */
    public function showStudent($id)
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        return $this->render('student/show.html.twig', array("student" => $student));
    }

    /**
     * @Route("/update/{id}", name="updateStudent")
     */
    public function updateStudent(Request $request, $id)
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        $form = $this->createForm(StudentType::class, $student);
        $form->add('modifier',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('student');
        }
        return $this->render("student/update.html.twig", array('form' => $form->createView()));
    }
    /**
     * @Route("/delete/{id}", name="deleteStudent")
     */
    public function deleteStudent($id)
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($student);
        $em->flush();
        return $this->redirectToRoute("student");
    }



    /**
     * @Route("/listStudentWithSearche", name="searchstudent")
     */
    public function listStudentWithSearch(Request $request)
    {   $repository = $this->getDoctrine()->getRepository(Student::class);

        //Show all students
        $students = $repository->findAll();
        //Formulaire de recherche
        $searchForm = $this->createForm(SearchStudentType::class);
        $searchForm->handleRequest($request);
        if ($searchForm->isSubmitted()) {
            $nsc = $searchForm['nsc']->getData();
            $resultOfSearch = $repository->searchStudent($nsc);
            return $this->render('student/searchStudent.html.twig', array(
                'resultOfSearch' => $resultOfSearch,
                'formsearch' => $searchForm->createView()));
        }
       return $this->render('student/list.html.twig', ['students' => $students,'formsearch'=>$searchForm->createView()]);
    }

    //Question 3 -DQL
    /**
     * @Route("/searchStudentByClub", name="searchStudentByClub")
     */
    public function searchStudentByClub(Request $request){
        $repository = $this->getDoctrine()->getRepository(Student::class);
        $repositoryclub=$this->getDoctrine()->getRepository(Club::class);
        //Show all students
        $students = $repository->findAll();
        //Formulaire de recherche
        $searchForm = $this->createForm(SearchStudentByClubType::class);
        $searchForm->add('Search',SubmitType::class);
        $searchForm->handleRequest($request);
        if ($searchForm->isSubmitted()) {
            $name=$searchForm['ref']->getData();
            $resultOfSearch = $repository->findStudentByClub($name);

            $club= $repositoryclub->findByRef($name);
            return $this->render('student/SearchStudentByClub.html.twig', array(
                'students' => $resultOfSearch,
                'clubs'=>$club,
                'formsearch' => $searchForm->createView()));
        }
       return $this->render('student/listStudentByClub.html.twig', ['students' => $students,'formsearch'=>$searchForm->createView()]);

    }
}
