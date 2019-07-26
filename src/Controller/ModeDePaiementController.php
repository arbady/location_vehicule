<?php

namespace App\Controller;

use App\Entity\ModeDePaiement;
use App\Form\ModeDePaiementType;
use App\Repository\ModeDePaiementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mode/de/paiement")
 */
class ModeDePaiementController extends AbstractController
{
    /**
     * @Route("/", name="mode_de_paiement_index", methods={"GET"})
     */
    public function index(ModeDePaiementRepository $modeDePaiementRepository): Response
    {
        return $this->render('mode_de_paiement/index.html.twig', [
            'mode_de_paiements' => $modeDePaiementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="mode_de_paiement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $modeDePaiement = new ModeDePaiement();
        $form = $this->createForm(ModeDePaiementType::class, $modeDePaiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($modeDePaiement);
            $entityManager->flush();

            return $this->redirectToRoute('mode_de_paiement_index');
        }

        return $this->render('mode_de_paiement/new.html.twig', [
            'mode_de_paiement' => $modeDePaiement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mode_de_paiement_show", methods={"GET"})
     */
    public function show(ModeDePaiement $modeDePaiement): Response
    {
        return $this->render('mode_de_paiement/show.html.twig', [
            'mode_de_paiement' => $modeDePaiement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="mode_de_paiement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ModeDePaiement $modeDePaiement): Response
    {
        $form = $this->createForm(ModeDePaiementType::class, $modeDePaiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mode_de_paiement_index', [
                'id' => $modeDePaiement->getId(),
            ]);
        }

        return $this->render('mode_de_paiement/edit.html.twig', [
            'mode_de_paiement' => $modeDePaiement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mode_de_paiement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ModeDePaiement $modeDePaiement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$modeDePaiement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($modeDePaiement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('mode_de_paiement_index');
    }
}
