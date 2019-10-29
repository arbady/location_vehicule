<?php

namespace App\Controller;

use App\Repository\AgenceRepository;
use App\Repository\CategorieRepository;
use App\Repository\DisponibiliteRepository;
use App\Repository\ReservationRepository;
use App\Repository\VehiculeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Sodium\add;
use Mpdf\Mpdf;
class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     * @param Request $request
     * @param AgenceRepository $t_agence
     * @param CategorieRepository $t_cat
     * @return Response
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

    /**
     * @Route("/testpdf", name="testpdf")
     */
    public function testpdf()
    {
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML('<h1>Hello world!</h1>');
        return new Response($mpdf->Output('nom_psd.pdf','I'));
    }

    /**
     * @Route("/form_index", name="form_index")
     * @param Request $request
     * @param DisponibiliteRepository $disponibiliteRepository
     * @param AgenceRepository $agenceRepository
     * @param CategorieRepository $categorieRepository
     * @param VehiculeRepository $vehiculeRepository
     * @param ReservationRepository $reservationRepository
     * @return Response
     */
    public function form_index(Request $request,DisponibiliteRepository $disponibiliteRepository, AgenceRepository $agenceRepository, CategorieRepository $categorieRepository, VehiculeRepository $vehiculeRepository, ReservationRepository $reservationRepository): Response
    {
        /*  START FORM */
        $id_agence = $request->get("id_agence");
        $agence_req = $agenceRepository->find($id_agence);
        $dateDepart = $request->get("date1");
        $dateRetour = $request->get("date2");
        $id_categorie = $request->get("id_cat");
        $vehicules = $vehiculeRepository->findAll();
        /* END FOR M*/


        /*  START recherche  des disponibilités en fonction des dates choisies par l'utilisateur */
        /* 0 compris dans les scripts 1 2 */
        $calcul_date =  (strtotime($dateRetour) - strtotime($dateDepart))/60/60/24 ;
        $table_disponibilites= array();
        $cpt_tmp = 0;

        foreach ($vehicules as $vehicule){
            $real_debut_date = date('Y-m-d',strtotime($dateDepart));
            $estTjrsDispo = true;

            for($i=0; $i<=$calcul_date ; $i++ ){

                $estDispoAlaDate = false;

                foreach ( $vehicule->getDisponibilites() as $disponibilite) {

                    if($disponibilite->getAgence()->getVille() === $agence_req->getVille() && $disponibilite->getDate()->getDate()->format('Y-m-d') == $real_debut_date){
                        $estDispoAlaDate = true;
                    }
                    $real_debut_date = date('Y-m-d', strtotime("+$i days",strtotime($dateDepart)));
                }
                if ($estDispoAlaDate == false){
                    $estTjrsDispo = false;
                }
            }
            if ($estTjrsDispo != false){

                if ($id_categorie){

                    if ($vehicule->getCategorie()->getId() == $id_categorie){
                        $table_disponibilites[$cpt_tmp] = $vehicule;
                        $cpt_tmp++;
                    }

                    else{}
                }

                else{
                    $table_disponibilites[$cpt_tmp] = $vehicule;
                    $cpt_tmp++;
                }
            }
        }

        return $this->render('vehicule/page_vehicule_filtre.html.twig', [
            'tableau_par_agences' =>   $table_disponibilites,
            'dateDepart'=>date('Y-m-d', strtotime($dateDepart)),
            'dateRetour'=>date('Y-m-d', strtotime($dateRetour)),
            'calcul_date'=>$calcul_date
        ]);

    }
}
