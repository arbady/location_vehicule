<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Form\VehiculeType;
use App\Repository\AgenceRepository;
use App\Repository\CategorieRepository;
use App\Repository\VehiculeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/vehicule")
 */
class VehiculeController extends AbstractController
{
    /**
     * @Route("/", name="vehicule_index", methods={"GET"})
     * @param VehiculeRepository $vehiculeRepository
     * @param AgenceRepository $t_agence
     * @param CategorieRepository $t_cat
     * @return Response
     */
    public function index(VehiculeRepository $vehiculeRepository, AgenceRepository $t_agence, CategorieRepository $t_cat): Response
    {
        $tab_agences = $t_agence->findAll();
        $tab_cat = $t_cat->findAll();

//        dump($vehiculeRepository->findAll()) ;

        return $this->render('vehicule/index.html.twig', [
            'vehicules' => $vehiculeRepository->findAll(),
            'tab_agences' => $tab_agences,
            'tab_cat' => $tab_cat
        ]);
    }

    /**
     * @Route("/new", name="vehicule_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $vehicule = new Vehicule();
        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vehicule);
            $entityManager->flush();

            return $this->redirectToRoute('vehicule_index');
        }

        return $this->render('vehicule/new.html.twig', [
            'vehicule' => $vehicule,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vehicule_show", methods={"GET"})
     */
    public function show(Vehicule $vehicule): Response
    {
        return $this->render('vehicule/show.html.twig', [
            'vehicule' => $vehicule,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="vehicule_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Vehicule $vehicule): Response
    {
        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vehicule_index');
        }

        return $this->render('vehicule/edit.html.twig', [
            'vehicule' => $vehicule,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vehicule_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Vehicule $vehicule): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vehicule->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($vehicule);
            $entityManager->flush();
        }

        return $this->redirectToRoute('vehicule_index');
    }

    /**
     * @Route("/", name="shows_index", methods={"GET"})
     * @param Vehicule $vehicule
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function pagination( VehiculeRepository $vehiculeRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $pagination = $paginator->paginate(

            $this->$vehiculeRepository->findAll();
            $pagination = $paginator->paginate(
//            $query,
            $request->query->getInt('page', 1),
            3
        );
        dump($pagination);
        return $this->render('vehicule/index.html.twig', [
            'vehicule' => $pagination,

        ]);
    }

//    public function listAction(Request $request)
//    {
//        $em    = $this->get('doctrine.orm.entity_manager');
//        $dql   = "SELECT a FROM AcmeMainBundle:Article a";
//        $query = $em->createQuery($dql);
//
//        $paginator  = $this->get('knp_paginator');
//        $pagination = $paginator->paginate(
//            $query, /* query NOT result */
//            $request->query->getInt('page', 1), /*page number*/
//            10 /*limit per page*/
//        );
//
//        // parameters to template
//        return $this->render('vehicule/index.html.twig', [
//            'pagination' => $pagination,
//        ]);
//    }
}
