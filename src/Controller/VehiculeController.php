<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Form\VehiculeType;
use App\Repository\AgenceRepository;
use App\Repository\CategorieRepository;
use App\Repository\ReservationRepository;
use App\Repository\VehiculeRepository;
use Doctrine\Common\Persistence\ObjectManager;
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
     * @param VehiculeRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(VehiculeRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/", name="vehicule_index", methods={"GET"})
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @param ReservationRepository $reservations
     * @param AgenceRepository $t_agence
     * @param CategorieRepository $t_cat
     * @return Response
     */
//    public function index(PaginatorInterface $paginator, Request $request, ReservationRepository $reservations, AgenceRepository $t_agence, CategorieRepository $t_cat): Response
//    {
//        $tab_agences = $t_agence->findAll();
//        $tab_cat = $t_cat->findAll();
//        $tab_res = $reservations->findAll();
//
//        $vehicules = $paginator->paginate(
//            $this->repository->findAll(),
//            $request->query->getInt('page', 1),
//            6
//        );
//
//        return $this->render('vehicule/index.html.twig', [
//            'vehicules' => $vehicules,
//            'tab_agences' => $tab_agences,
//            'tab_cat' => $tab_cat,
//            'reservations' => $tab_res
//        ]);
//    }
    public function index(ReservationRepository $reservations, AgenceRepository $t_agence, CategorieRepository $t_cat, VehiculeRepository $vehiculeRepository): Response
    {
        $tab_agences = $t_agence->findAll();
        $tab_cat = $t_cat->findAll();
        $tab_res = $reservations->findAll();
        $vehicules = $vehiculeRepository->findAll();

        return $this->render('vehicule/index.html.twig', [
            'vehicules' => $vehicules,
            'tab_agences' => $tab_agences,
            'tab_cat' => $tab_cat,
            'reservations' => $tab_res
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
            $unique = $vehicule->getMatricule();

            if($entityManager->getRepository('App\Entity\Vehicule')->findBy(array('matricule' => $unique)))
            {
                return $this->render('vehicule/new.html.twig', [
                    'vehicule' => $vehicule,
                    'form' => $form->createView(),
                    'erreur' => "Le code est déjà utilisé",
                ]);
            }
            else{
                $entityManager->persist($vehicule);
                $entityManager->flush();

                return $this->redirectToRoute('vehicule_index');
            }
        }

        return $this->render('vehicule/new.html.twig', [
            'vehicule' => $vehicule,
            'form' => $form->createView(),
            'erreur' => "Le code est déjà utilisé",
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
//        $vehicules = $paginator->paginate(
//            $this->repository->findAllVisibleQuery(),
////            $query,
//            $request->query->getInt('page', 1),
//            9
//        );
////        dump($pagination);
//        return $this->render('vehicule/index.html.twig', [
//            'vehicules' => $pagination
//
//        ]);
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
