<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Form\VehiculeType;
use App\Repository\AgenceRepository;
use App\Repository\CategorieRepository;
use App\Repository\DisponibiliteRepository;
use App\Repository\EtatRepository;
use App\Repository\ReservationRepository;
use App\Repository\VehiculeRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Exception;
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
     * @param Request $request
     * @param DisponibiliteRepository $t_dispo
     * @param ReservationRepository $reservations
     * @param EtatRepository $t_etats
     * @param AgenceRepository $t_agence
     * @param CategorieRepository $t_cat
     * @param VehiculeRepository $vehiculeRepository
     * @return Response
     * @throws Exception
     */
    public function index(Request $request, DisponibiliteRepository $t_dispo, ReservationRepository $reservations, EtatRepository $t_etats, AgenceRepository $t_agence, CategorieRepository $t_cat, VehiculeRepository $vehiculeRepository): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $tab_agences = $t_agence->findAll();
        $tab_cat = $t_cat->findAll();
        $tab_res = $reservations->findAll();
        $vehicules = $vehiculeRepository->findAll();

//        Si la date de reservation arrive à la fin, le véhicule doit pouvoir être à nouveau disponible à la nouvelle agence

        $today = date('m/d/Y');
        $t1 = new \DateTime($today);
        foreach ($vehicules as $vehicule){

            $ligneDispo = $vehicule->getDisponibilites();

            $estDispo = false;
            $lieuDispo = $ligneDispo->get(0)->getAgence()->getId();

            foreach ($ligneDispo as $vehicDispo){
                $dispo = $vehicDispo->getDate();

                if (($dispo == $t1)){
                    $lieuDispo = $vehicDispo->getAgence()->getId();
                    $estDispo = true;
                }

            }
            $vehicule->setLieuVehic($lieuDispo);

            if ($estDispo){
                $etats = $t_etats->find(5);
                $vehicule->setEtat($etats);
                $entityManager->persist($vehicule);
            }
            else{
                $etats = $t_etats->find(6);
                $vehicule->setEtat($etats);
                $entityManager->persist($vehicule);
            }
        }
        $entityManager->flush();

        return $this->render('vehicule/index.html.twig', [
            'vehicules' => $vehicules,
            'tab_agences' => $tab_agences,
            'tab_cat' => $tab_cat,
            'reservations' => $tab_res
        ]);
    }

    /**
     * @Route("/new", name="vehicule_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
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
     * @param Vehicule $vehicule
     * @return Response
     */
    public function show(Vehicule $vehicule): Response
    {
        return $this->render('vehicule/show.html.twig', [
            'vehicule' => $vehicule,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="vehicule_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Vehicule $vehicule
     * @return Response
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
     * @param Request $request
     * @param Vehicule $vehicule
     * @return Response
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
     * @param VehiculeRepository $vehiculeRepository
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
