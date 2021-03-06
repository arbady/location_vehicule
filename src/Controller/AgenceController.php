<?php

namespace App\Controller;

use App\Entity\Agence;
use App\Form\AgenceType;
use App\Repository\AgenceRepository;
use App\Repository\VehiculeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/agence")
 */
class AgenceController extends AbstractController
{
    /**
     * @Route("/", name="agence_index", methods={"GET"})
     * @param AgenceRepository $agenceRepository
     * @return Response
     */
    public function index(AgenceRepository $agenceRepository): Response
    {
        return $this->render('agence/index.html.twig', [
            'agences' => $agenceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="agence_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $agence = new Agence();
        $form = $this->createForm(AgenceType::class, $agence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($agence);
            $entityManager->flush();

            return $this->redirectToRoute('agence_index');
        }

        return $this->render('agence/new.html.twig', [
            'agence' => $agence,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="agence_show", methods={"GET"})
     * @param VehiculeRepository $vehiculeRepository
     * @param Agence $agence
     * @param $id
     * @return Response
     * @throws \Exception
     */
    public function show(VehiculeRepository $vehiculeRepository, Agence $agence, $id): Response
    {
        $vehicules = $vehiculeRepository->findAll();
        $t1 = date('m/d/Y');
        $today = new \DateTime($t1);
        $table_disponibilites = array();
        $cpt_tmp = 0;

        foreach ($vehicules as $vehicule){

            foreach ( $vehicule->getDisponibilites() as $disponibilite) {
                if($disponibilite->getAgence()->getId() == $id && $disponibilite->getDate()->getDate()->getTimestamp() == $today->getTimestamp()){
                    $table_disponibilites[$cpt_tmp] = $vehicule;
                }
            }
            $cpt_tmp++;
        }
        return $this->render('agence/show.html.twig', [
            'tableau_par_agences' =>   $table_disponibilites,
            'agence' => $agence
        ]);
    }

    /**
     * @Route("/{id}/edit", name="agence_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Agence $agence
     * @return Response
     */
    public function edit(Request $request, Agence $agence): Response
    {
        $form = $this->createForm(AgenceType::class, $agence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('agence_index', [
                'id' => $agence->getId(),
            ]);
        }

        return $this->render('agence/edit.html.twig', [
            'agence' => $agence,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="agence_delete", methods={"DELETE"})
     * @param Request $request
     * @param Agence $agence
     * @return Response
     */
    public function delete(Request $request, Agence $agence): Response
    {
        if ($this->isCsrfTokenValid('delete'.$agence->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($agence);
            $entityManager->flush();
        }

        return $this->redirectToRoute('agence_index');
    }
}
