<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Form\FactureType;
use App\Repository\AgenceRepository;
use App\Repository\FactureRepository;
use Mpdf\MpdfException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/facture")
 */
class FactureController extends AbstractController
{
    /**
     * @Route("/", name="facture_index", methods={"GET"})
     * @param FactureRepository $factureRepository
     * @return Response
     */
    public function index(FactureRepository $factureRepository): Response
    {
        return $this->render('facture/index.html.twig', [
            'factures' => $factureRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="facture_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $facture = new Facture();
        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($facture);
            $entityManager->flush();

            return $this->redirectToRoute('facture_index');
        }

        return $this->render('facture/new.html.twig', [
            'facture' => $facture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="facture_show", methods={"GET"})
     * @param Facture $facture
     * @return Response
     */
    public function show(Facture $facture): Response
    {
        return $this->render('facture/show.html.twig', [
            'facture' => $facture,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="facture_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Facture $facture
     * @return Response
     */
    public function edit(Request $request, Facture $facture): Response
    {
        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('facture_index', [
                'id' => $facture->getId(),
            ]);
        }

        return $this->render('facture/edit.html.twig', [
            'facture' => $facture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="facture_delete", methods={"DELETE"})
     * @param Request $request
     * @param Facture $facture
     * @return Response
     */
    public function delete(Request $request, Facture $facture): Response
    {
        if ($this->isCsrfTokenValid('delete'.$facture->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($facture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('facture_index');
    }

    /**
     * @Route("/facture_pdf/{id}", name="facture_id")
     * @param $id
     * @param FactureRepository $factureRepository
     * @param AgenceRepository $t_agences
     * @return Response
     * @throws MpdfException
     */
    public function facturePdfParId($id,FactureRepository  $factureRepository, AgenceRepository $t_agences)
    {
        setlocale(LC_TIME, 'fr_FR.utf8', 'fra');

        $facture = $factureRepository->find($id);
        $user_identity = $this->getUser()->getAdresse();
        $nom = $this->getUser()->getNom();
        $tel = $this->getUser()->getTelephone();
        $mail = $this->getUser()->getEmail();
        $num_facture = $facture->getNumFacture();
        $cout_par_jour = $facture->getContrat()->getReservation()->getCategorie()->getCoutParJour();
        $couvDom = $facture->getContrat()->getReservation()->getCouvertureDommage();
        $couvVol = $facture->getContrat()->getReservation()->getCouvertureVol();
        $age = $facture->getContrat()->getReservation()->getTrancheAge();

        $dDepart = $facture->getContrat()->getReservation()->getDateDebutLoc();
        $dRetour = $facture->getContrat()->getReservation()->getDateFinLoc();
        $nbJour = $dDepart->diff($dRetour)->days;
        $dDep = ucfirst(strftime('%A %e %B %Y', $dDepart->getTimestamp()));
        $dRet = ucfirst(strftime('%A %e %B %Y', $dRetour->getTimestamp()));

        $dFact = $facture->getContrat()->getDateContrat();
        $dateFacture = ucfirst(strftime('%A %e %B %Y', $dFact->getTimestamp()));

        $libelle = $facture->getLibelle();
        $num_contrat = $facture->getContrat()->getNumContrat();
        $agenceDep = $facture->getContrat()->getReservation()->getAgence()->getVille();
        $agenceRet = $t_agences->find($facture->getContrat()->getReservation()->getAgenceRetour())->getVille();
        $coutTottva = $facture->getContrat()->getReservation()->getMontantTotTva();
        $coutTotHtva = $facture->getContrat()->getMontantTotHtva();
        $paye = $facture->getPaye();

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P']);

        $stylesheet = file_get_contents('css/facture.css');

        $mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);

        $mpdf->WriteHTML(" 
            <head>
              <meta charset=\"UTF-8\"/>
              <title>Facture MyCaag</title>
              <link href=\"https://fonts.googleapis.com/css?family=Nunito:300|Raleway:200,300\" rel=\"stylesheet\" type=\"text/css\"/>
            </head>
            
            <body>
              <header>
                <h1>FACTURE<h5>MYCAAG − Location de Véhicule</h5></h1>
                <hr>
              </header>              
              <section class=\"flex\" style=\"margin-top: 3%; margin-left: 1.5%; width: 93.3%\">
                <table>
                  <tr> 
                    <th>Facture #</th>
                    <th>Date de facturation</th>
                    <th>Contrat #</th>
                  </tr>
                  <tr>
                    <td style=\"text-align: center;\">$num_facture</td>
                    <td style=\"text-align: center;\">$dateFacture</td>
                    <td style=\"text-align: center;\">$num_contrat</td>
                  </tr>
                </table>                   
              </section>
              <section class=\"flex\">
                <dl class=\"bloc\">
                    <dt style='text-align: left; font-weight: bold'>Facturé à :</dt>
                    <dd>
                      $user_identity<br>
                      Belgique
                      <p style='margin-top: 2%'>
                          <dt style='text-align: left; font-style: italic'>Nom : </dt><dd>$nom</dd><br>
                          <dt style='text-align: left; font-style: italic'>Téléphone</dt><dd>$tel</dd><br>
                          <dt style='text-align: left; font-style: italic'>Courriel</dt><dd>$mail</dd>
                      </p>
                    </dd>
                </dl>
                <dl class=\"bloc\">
                  <dt style=\"text-align: left; font-weight: bold\">Description :</dt>
                  <dd>$libelle</dd><br>
                  <dt style=\"text-align: left; font-weight: bold\">Période de reservation :</dt>
                  <dd>Du $dDep au $dRet</dd><br>
                  <dt style=\"text-align: left; font-weight: bold\">Agence de départ :</dt>
                  <dd>$agenceDep</dd><br>
                  <dt style=\"text-align: left; font-weight: bold\">Agence de retour :</dt>
                  <dd>$agenceRet</dd>
                </dl>
              </section>
              <table style='margin-left: 3%; width: 96%'>
                <thead>
                  <tr> 
                    <th style=\"font-weight: bold\">couv. dommage</th>
                    <th style=\"font-weight: bold\">couv. vol</th>
                    <th style=\"font-weight: bold\">tranche age</th>
                    <th style=\"font-weight: bold\">Nombre de jour</th>
                    <th style=\"font-weight: bold\">Coût/Jour</th>
                    <th style=\"font-weight: bold\">Coût totalHTVA</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td style=\"text-align: center\">$couvDom €</td>
                    <td style='text-align: center'>$couvVol €</td>
                    <td style='text-align: center'>$age €</td>
                    <td style='text-align: center'>$nbJour</td>
                    <td style='text-align: center'>$cout_par_jour €</td>
                    <td style='text-align: center'>$coutTotHtva €</td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr> 
                    <td colspan=\"4\"></td>
                    <td>TotalTTC:</td>
                    <td style='text-align: center'>$coutTottva €</td>
                  </tr>
                </tfoot>
              </table>
            </body>
        ");

        $mpdf->SetHTMLFooter('
            <footer>
                <p style="text-align: center">MYCAAG – Informatique − Développement WEB | <a href="\"http://mycaag.be\"">mycaag.be</a></p>
                <p style="text-align: center">1000 Bruxelles, Avenue Louise, 121 | Tél. 046-642-3930 | <a href=\"mycaag.be\">infos@mycaag.be</a></p>
            </footer>
            <div class="footer">
                <table width="100%">
                    <tr>                       
                        <td width="33%" align="center">{PAGENO}/{nbpg}</td>                      
                    </tr>
                </table>             
            </div>    
        ');

//        $mpdf->AddPage();
        $mpdf->AddPage('L','','','','',0,0,0,0,10,10);
        $mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);

        $mpdf->WriteHTML("
            <body id='back_col'>
                <div id='back_img'><p>bonjour</p></div>
            </body>
        " );
//

        $mpdf->SetHTMLFooter('
            <footer>
                <p style="text-align: center">MYCAAG – Informatique − Développement WEB | <a href="\"http://mycaag.be\"">mycaag.be</a></p>
                <p style="text-align: center">1000 Bruxelles, Avenue Louise, 121 | Tél. 046-642-3930 | <a href=\"mycaag.be\">infos@mycaag.be</a></p>
            </footer>
            <div class="footer">
                <table width="100%">
                    <tr>                       
                        <td width="33%" align="center">{PAGENO}/{nbpg}</td>                      
                    </tr>
                </table>             
            </div>    
        ');
        return new Response($mpdf->Output('nom_psd.pdf','I'));
    }
}
