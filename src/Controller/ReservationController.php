<?php

namespace App\Controller;

use App\Entity\Disponibilite;
use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\AgenceRepository;
use App\Repository\CategorieRepository;
use App\Repository\ReservationRepository;
use App\Repository\VehiculeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reservation")
 */
class ReservationController extends AbstractController
{
    /**
     * @Route("/", name="reservation_index", methods={"GET","POST"})
     */
    public function index(Request $request, ReservationRepository $reservationRepository, AgenceRepository $t_agence, CategorieRepository $t_cat, VehiculeRepository $vehicules): Response
    {
        $vehicule_id = $request->get('id');
        $tab_agences = $t_agence->findAll();
        $tab_cat = $t_cat->findAll();
//        dd($vehicule_id);
        if ($vehicule_id){
            $vehicule = $vehicules->find($vehicule_id);

            return $this->render('reservation/index.html.twig', [
                'reservations' => $reservationRepository->findAll(),
                'tab_agences' => $tab_agences,
                'tab_cat' => $tab_cat,
                'vehicule' => $vehicule
            ]);
        }
       else{
           return $this->redirectToRoute('vehicule_index');
       }
    }

    /**
     * @Route("/new", name="reservation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $id_agence = $request->get("id_agence");
        $retour = $request->get("retour");
        $date1 = $request->get("date1");
        $date2 = $request->get("date2");
        $usr_time1 = $request->get("usr_time1");
        $usr_time2 = $request->get("usr_time2");
        $option1 = $request->get("option1");
        $option2 = $request->get("option2");
        $radio1 = $request->get("radio1");
        $radio2 = $request->get("radio2");
        $id_vehicule = $request->get("id_vehicule");

//        Tester si l'agence de retour est égale à l'agence de depart

        $entityManager = $this->getDoctrine()->getManager();

        $disponibilites = new Disponibilite();

//        $entityManager->findBy($id_vehicule);

//        $entityManager->persist($disponibilites);
//        $entityManager->flush();

//        if ($retour == "on"){
//            $id_agence
//        }

        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('reservation_index');
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_show", methods={"GET"})
     */
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reservation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reservation $reservation): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reservation_index');
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Reservation $reservation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reservation_index');
    }
}
