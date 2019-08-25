<?php

namespace App\Controller;

use App\Repository\AgenceRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(Request $request, AgenceRepository $t_agence, CategorieRepository $t_cat): Response
    {
        //$id_agence = $request->query->get('id_agence');
        $tab_agences = $t_agence->findAll();
        $tab_cat = $t_cat->findAll();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'tab_agences' => $tab_agences,
            'tab_cat' => $tab_cat
        ]);
    }
}
