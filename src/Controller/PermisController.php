<?php

namespace App\Controller;

use App\Entity\Permis;
use App\Form\PermisType;
use App\Repository\PermisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/permis")
 */
class PermisController extends AbstractController
{
    /**
     * @Route("/", name="permis_index", methods={"GET"})
     */
    public function index(PermisRepository $permisRepository): Response
    {
        return $this->render('permis/index.html.twig', [
            'permis' => $permisRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="permis_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $permi = new Permis();
        $form = $this->createForm(PermisType::class, $permi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($permi);
            $entityManager->flush();

            return $this->redirectToRoute('permis_index');
        }

        return $this->render('permis/new.html.twig', [
            'permi' => $permi,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="permis_show", methods={"GET"})
     */
    public function show(Permis $permi): Response
    {
        return $this->render('permis/show.html.twig', [
            'permi' => $permi,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="permis_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Permis $permi): Response
    {
        $form = $this->createForm(PermisType::class, $permi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('permis_index', [
                'id' => $permi->getId(),
            ]);
        }

        return $this->render('permis/edit.html.twig', [
            'permi' => $permi,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="permis_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Permis $permi): Response
    {
        if ($this->isCsrfTokenValid('delete'.$permi->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($permi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('permis_index');
    }
}
