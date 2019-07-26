<?php

namespace App\Controller;

use App\Entity\Penalisation;
use App\Form\PenalisationType;
use App\Repository\PenalisationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/penalisation")
 */
class PenalisationController extends AbstractController
{
    /**
     * @Route("/", name="penalisation_index", methods={"GET"})
     */
    public function index(PenalisationRepository $penalisationRepository): Response
    {
        return $this->render('penalisation/index.html.twig', [
            'penalisations' => $penalisationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="penalisation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $penalisation = new Penalisation();
        $form = $this->createForm(PenalisationType::class, $penalisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($penalisation);
            $entityManager->flush();

            return $this->redirectToRoute('penalisation_index');
        }

        return $this->render('penalisation/new.html.twig', [
            'penalisation' => $penalisation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="penalisation_show", methods={"GET"})
     */
    public function show(Penalisation $penalisation): Response
    {
        return $this->render('penalisation/show.html.twig', [
            'penalisation' => $penalisation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="penalisation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Penalisation $penalisation): Response
    {
        $form = $this->createForm(PenalisationType::class, $penalisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('penalisation_index', [
                'id' => $penalisation->getId(),
            ]);
        }

        return $this->render('penalisation/edit.html.twig', [
            'penalisation' => $penalisation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="penalisation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Penalisation $penalisation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$penalisation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($penalisation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('penalisation_index');
    }
}
