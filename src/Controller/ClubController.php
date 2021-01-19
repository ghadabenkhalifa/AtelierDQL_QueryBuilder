<?php

namespace App\Controller;

use App\Entity\Club;
use App\Form\ClubType;
use App\Form\SearchPriceType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClubController extends AbstractController
{


    /**
     * @Route("/listclub", name="club")
     */
    public function listClub()
    {
        $clubs = $this->getDoctrine()->getRepository(Club::class)->findAll();
        $clubsByDate= $this->getDoctrine()->getRepository(Club::class)->orderByDate();
        $enabledClubs = $this->getDoctrine()->getRepository(Club::class)->findEnabledClub();
        return $this->render('club/list.html.twig', array(
            "clubs" => $clubs,
            "clubByDate"=>$clubsByDate,
            "enabledClub"=>$enabledClubs));
    }


    /**
     * @Route("/deleteclub/{id}", name="deleteClub")
     */
    public function deleteClub($id)
    {
        $club = $this->getDoctrine()->getRepository(Club::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($club);
        $em->flush();
        return $this->redirectToRoute("club");
    }

    /**
     * @Route("/showclub/{id}", name="showClub")
     */
    public function showClub($id)
    {
        $club = $this->getDoctrine()->getRepository(Club::class)->find($id);
        return $this->render('club/show.html.twig', array("club" => $club));
    }

    /**
     * @Route("/addclub", name="addClub")
     */
    public function addClub(Request $request)
    {
        $club = new Club();
        $form = $this->createForm(ClubType::class, $club);
        $form->add('ajouter',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($club);
            $em->flush();
            return $this->redirectToRoute('club');
        }
        return $this->render("club/add.html.twig",array('form'=>$form->createView()));
    }

    /**
     * @Route("/updateclub/{id}", name="updateClub")
     */
    public function updateClub(Request $request,$id)
    {
        $club = $this->getDoctrine()->getRepository(Club::class)->find($id);
        $form = $this->createForm(ClubType::class, $club);
        $form->add('modifier',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('club');
        }
        return $this->render("club/update.html.twig",array('form'=>$form->createView()));
    }

    /**
     * @Route("/ClubParPrix/", name="clubParPrix")
     * @param Request $request
     * @return Response
     */
    public function clubParPrix(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Club::class);
        //Show all club
        $clubs = $repository->findAll();
        $searchForm = $this->createForm(SearchPriceType::class);
        $searchForm->add('Search',SubmitType::class);
        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted()) {
            $minPrice=(int)$searchForm['minPrice']->getData();
            $maxPrice=(int)$searchForm['maxPrice']->getData();

           // $nsc = $searchForm['minPrice']->getData();
            $resultOfSearch = $repository->findByPriceRange($minPrice,$maxPrice);

            return $this->render('club/searchClub.html.twig', array(
                'clubs' => $resultOfSearch,
                'formsearch' => $searchForm->createView()));
        }
        return $this->render('club/list.html.twig', ['clubs' => $clubs,'formsearch'=>$searchForm->createView()]);
    }

    /**
     * @Route("/ClubParDate/", name="clubParDate")
     * @return Response
     */
    public function clubParDate()
    {
        $repository = $this->getDoctrine()->getRepository(Club::class);
        //Show all club
        $clubs = $repository->clubPerDate(new DateTime('2020-11-02'),new DateTime('2021-12-16'));
       return $this->render('club/listParDate.html.twig', ['clubs' => $clubs]);
    }



}
