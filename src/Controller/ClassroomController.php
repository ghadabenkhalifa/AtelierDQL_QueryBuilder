<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Entity\Student;
use App\Form\ClassroomType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{
    /**
     * @Route("/classroom", name="classroom")
     */
    public function index()
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }

    /**
     * @Route("/listclassroom", name="list")
     */
    public function list(){
        $listClassroom=$this->getDoctrine()
            ->getRepository(Classroom::class)
            ->findAll();
        return $this->render('classroom/list.html.twig', [
            'list'=>$listClassroom
        ]);
    }

    /**
     * @Route("/deleteClassroom/{id}", name="deleteClassroom")
     */
    public function deleteClassroom($id)
    {
        $em = $this->getDoctrine()->getManager();
        $classe = $em->getRepository(Classroom::class)->find($id);
        $em->remove($classe);
        $em->flush();

        return $this->redirectToRoute("list");
    }

    /**
     * @Route ("/create", name="createClassic")
     * @param Request $request

     */
    public function createClassroom(Request $request){
        if($request->request->count()>0){
            $classromm=new Classroom();
            $classromm->setName($request->get('nom'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($classromm);
            $em->flush();
            return $this->redirectToRoute('list');
        }
        return $this->render('classroom/newclassic.html.twig');

    }

   /**
     * @Route("/updateClassroom/{id}", name="updateClassroom")
     */

    public function updateClassroom(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $classroom = $em->getRepository(Classroom::class)->find($id);
        $form = $this->createForm(ClassroomType::class,
            $classroom);
        $form->add('Modifier', SubmitType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('list');
        }

        return $this->render("classroom/update.html.twig", [
            "form" => $form->createView(),
        ]);

    }

    ///QueryBuilder - Question3-
    /**
     * @Route("/show/{id}", name="showClassroom")
     */
    public function showClassroom($id)
    {
        $classroom = $this->getDoctrine()->getRepository(Classroom::class)->find($id);
        $students= $this->getDoctrine()->getRepository(Student::class)->listStudentByClass($classroom->getId());
        return $this->render('classroom/show.html.twig', array(
            "classroom" => $classroom,
            "students"=>$students));
    }
}
