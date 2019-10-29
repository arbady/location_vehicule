<?php

namespace App\Controller;

use App\Entity\Contrat;
use App\Entity\Disponibilite;
use App\Entity\Facture;
use App\Entity\Reservation;
use App\Entity\User;
use App\Form\ReservationType;
use App\Repository\AgenceRepository;
use App\Repository\CategorieRepository;
use App\Repository\DisponibiliteRepository;
use App\Repository\EtatRepository;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use App\Repository\VehiculeRepository;
use Mpdf\MpdfException;
use phpDocumentor\Reflection\Types\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/reservation")
 */
class ReservationController extends AbstractController
{
    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/", name="reservation_index", methods={"GET","POST"})
     * @param Request $request
     * @param ReservationRepository $reservationRepository
     * @param AgenceRepository $t_agence
     * @param CategorieRepository $t_cat
     * @param VehiculeRepository $vehicules
     * @return Response
     */
    public function index(Request $request, ReservationRepository $reservationRepository, AgenceRepository $t_agence, CategorieRepository $t_cat, VehiculeRepository $vehicules): Response
    {

        $vehicule_id = $request->get('id');

        if ($vehicule_id){
        }
        else{
            $vehicule_id = $_SESSION['vehiculeReserve'];
        }
        $_SESSION['vehiculeReserve'] = $vehicule_id;

        if ($vehicule_id){
            $vehicule = $vehicules->find($vehicule_id);
            $pays = $vehicule->getDisponibilites()->get(0)->getAgence()->getPays();
            $tab_agences = $t_agence->findBy([
                'pays' => $pays
            ]);
            $tab_cat = $t_cat->findAll();

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
     * @param Request $request
     * @param VehiculeRepository $t_vehicules
     * @return Response
     */
    public function new(Request $request, VehiculeRepository $t_vehicules): Response
    {
        $userClient = $this->getUser();

        if ($userClient instanceof User){

            $id_agence = $request->get("id_agence");
            $id_vehicule = $request->get("id_vehicule");
            $id_categorie = $request->get("id_categorie");
            $lieuRetour = $request->get("retour");
            $id_lieuDepart = $request->get("id_lieuDepart");
            $dateDepart = $request->get("date1");
            $dateRetour = $request->get("date2");
            $heureDepart = $request->get("usr_time1");
            $heureRetour = $request->get("usr_time2");
            $couvDom = $request->get("option1");
            $couvDommage = $request->get("couvDom");
            $couVol = $request->get("option2");
            $couvVols = $request->get("couvVol");
            $prixVehic = $request->get("prixVehic");
            $coutTot = $request->get("coutTot");
            $age = $request->get("age");
            $payer = $request->get("radio");

            $listeVar = array(
                "AGENCE" => $id_agence,
                "VEHICULE" => $id_vehicule,
                "CATEGORIE" => $id_categorie,
                "LIEU_RETOUR" => $lieuRetour,
                "LIEU_DEPART" => $id_lieuDepart,
                "DATE_RETOUR" => $dateRetour,
                "DATE_DEPART" => $dateDepart,
                "HEURE_DEPART" => $heureDepart,
                "HEURE_RETOUR" => $heureRetour,
                "COUV_DOMMAGE" => $couvDommage,
                "COUV_DOM" => $couvDom,
                "COUV_VOL" => $couVol,
                "COUV_VOLS" => $couvVols,
                "PRIX_VEHICULE" => $prixVehic,
                "COUT_TOT" => $coutTot,
                "AGE" => $age,
                "PAYER" => $payer
            );

            $_SESSION["listeVar"] = $listeVar;
            $_SESSION["COUTTOT"] = $coutTot;

            if ($this->dateCompare($dateDepart, $dateRetour, $id_vehicule, $t_vehicules)){
            }
            else{
                $this->addFlash('alert', 'La periode que vous avez choisie est déjà prise');
                return $this->redirectToRoute('reservation_index');
            }

            // Tester si l'agence de retour est égale à l'agence de depart

            if ($payer == 'online'){

                return $this->render('reservation/payeOnline.html.twig', [
                    'COUTTOT' => $coutTot
                ]);
            }
            else{

                return $this->render('reservation/payeAgence.html.twig', [
                    'COUTTOT' => $coutTot
                ]);
            }

        }
        else
        {
            if(!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
            {
                $this->addFlash('info', 'Vous devez vous authentifier pour acceder à cette page');
                return $this->redirectToRoute('app_login');
            }
        }
    }

    private function dateCompare($dateDepart, $dateRetour, $vehicule_id, $t_vehicules){
        $vehicule = $t_vehicules->find($vehicule_id);
//        $dateDepart1 = new \DateTime($dateDepart)
        $dateDepart1 = date('Y-m-d', strtotime($dateDepart));
        $dateRetour1 = date('Y-m-d', strtotime($dateRetour));
//        $dateRetour1 = new \DateTime($dateRetour);
        $disponibilites = $vehicule->getDisponibilites();
        $calcul_date =  (strtotime($dateRetour1) - strtotime($dateDepart1))/60/60/24 ;
        $real_debut_date = date('Y-m-d', strtotime($dateDepart1));
        $estTjrsDispo = true;

        for($i=0; $i<=$calcul_date ; $i++ ){

            $estDispoAlaDate = false;

            foreach ( $vehicule->getDisponibilites() as $disponibilite) {

                if($disponibilite->getDate()->getDate()->format('Y-m-d') == $real_debut_date){
                    $estDispoAlaDate = true;
                }
                $real_debut_date = date('Y-m-d', strtotime("+$i days",strtotime($dateDepart)));
            }
            if ($estDispoAlaDate == false){
                $estTjrsDispo = false;
            }
        }
        return $estTjrsDispo;
    }

    private function saveReservation($t_disponibilites, $t_agences, $t_vehicules, $t_etats, $verifPaiement){

        $entityManager = $this->getDoctrine()->getManager();

        $_listeVar = $_SESSION["listeVar"];

        $id_agence = $_listeVar["AGENCE"];
        $id_vehicule = $_listeVar["VEHICULE"];
        $id_categorie = $_listeVar["CATEGORIE"];
        $lieuRetour = $_listeVar["LIEU_RETOUR"];
        $id_lieuDepart = $_listeVar["LIEU_DEPART"];
        $dateDepart = $_listeVar["DATE_DEPART"];
        $dateRetour = $_listeVar["DATE_RETOUR"];
        $heureDepart = $_listeVar["HEURE_DEPART"];
        $heureRetour = $_listeVar["HEURE_RETOUR"];
        $couvDom = $_listeVar["COUV_DOM"];
        $couvDommage = $_listeVar["COUV_DOMMAGE"];
        $couVol = $_listeVar["COUV_VOL"];
        $couvVols = $_listeVar["COUV_VOLS"];
        $prixVehic = $_listeVar["PRIX_VEHICULE"];
        $coutTot = $_listeVar["COUT_TOT"];
        $age = $_listeVar["AGE"];
        $payer = $_listeVar["PAYER"];

        $agence_depart = $t_agences->find($id_lieuDepart);
        $vehicule = $t_vehicules->find($id_vehicule);
        $t1 = date('m/d/Y');
        $today = new \DateTime($t1);
        $dateDispoRetour = new \DateTime($dateRetour);
        $dateDispoDepart = new \DateTime($dateDepart);
        $heure = intval(substr($heureRetour,0, 2));
        $minute = intval(substr($heureRetour,3, 4));
        $dateDispoRetour->setTime($heure, $minute);

        $disponibilites = $t_disponibilites->findBy([
            "vehicule" => $vehicule->getId()
        ]);

        foreach ($disponibilites as $dispo){
            $dateCourante = $dispo->getDate()->getDate()->getTimeStamp();
            if ($dateCourante >= $dateDispoDepart->getTimeStamp() && $dateCourante <= $dateDispoRetour->getTimestamp()){
                $entityManager->remove($dispo);
            }
            elseif ($dateCourante > $dateDispoRetour->getTimestamp()){
                if ($lieuRetour == "on"){
//                    $agence = $t_agences->find($id_lieuDepart);
                    $agence = $t_agences->find($id_agence);
                    $dispo->setAgence($agence);
                    $entityManager->persist($dispo);
                }
                else{
                }
            }
        }
        $entityManager->flush();

//        $real_debut_date = $dateDispoDepart;
//        $i = 0;
//        while( $real_debut_date->getTimestamp() < $dateDispoRetour->getTimestamp()){
//            $real_debut_date;
//            $i++;
//            $real_debut_date = new \DateTime(date('Y-m-d', strtotime("+$i days",strtotime($dateDepart))));
//        }
//        dd($disponibilites->setDate());

//        Pour changer l'etat du véhicule
        if (($dateDispoDepart < $today) && ($today < $dateDispoRetour)){
            $etats = $t_etats->find(6);
            $vehicule->setEtat($etats);
        }
        else{
            $etats = $t_etats->find(5);
            $vehicule->setEtat($etats);
        }

        //  Traitement de la reservation
        $reservation = new Reservation();

        $reservation->denyAccessUnlessGranted('ROLE_USER');
        $user_identity = $this->getUser();

        $categorie = $vehicule->getCategorie();

        $dDepart = new \DateTime($dateDepart);
        $dRetour = new \DateTime($dateRetour);
        $montant_total = floatval($coutTot);
        $ac = $reservation->getAcompte();
        $acompte = floatval($ac);

        $reservation->setAgence($agence_depart);
        if ($lieuRetour == "on"){
            $reservation->setAgenceRetour($id_agence);
        }
        else{
            $reservation->setAgenceRetour($agence_depart->getId());
        }
        $reservation->setCategorie($categorie);
        $reservation->setUser($user_identity);
        $reservation->setDateRes($today);
        $reservation->setDateDebutLoc($dDepart);
        $reservation->setDateFinLoc($dRetour);
        $reservation->setCouvertureDommage($couvDommage);
        $reservation->setCouvertureVol($couvVols);
        $reservation->setTrancheAge($age);
        $reservation->setMontantTotTva($montant_total);
        $reservation->setAcompte($montant_total/10);

        if ($verifPaiement == "online"){
            $reservation->setAcomptePaye(true);
            $reservation->setToutPaye(true);
            $reservation->setStatutRes(true);
        }

        else{
            $reservation->setAcomptePaye(true);
            $reservation->setToutPaye(false);
            $reservation->setStatutRes(true);
        }
        $entityManager->persist($reservation);
        $entityManager->persist($vehicule);
        $entityManager->flush();

//        traitement d'un contrat
        $contrat = new Contrat();

        $num_contrat = $this->generateContrat();
        $t1 = date('m/d/Y');
        $today = new \DateTime($t1);
        $taux = 21/100;
        $montant_totalHTVA = $montant_total - ($montant_total * $taux);

        $contrat->setVehicule($vehicule);
        $contrat->setReservation($reservation);
        $contrat->setNumContrat($num_contrat);
        $contrat->setDateRetourReelle($reservation->getDateRes());
        $contrat->setDateContrat($today);
        $contrat->setKmDepart(0);
        $contrat->setKmRetour(0);
        $contrat->setMontantTotHtva($montant_totalHTVA);
        $contrat->setMontantTotTva($montant_total);
        $contrat->setSigne(false);

        $entityManager->persist($contrat);
        $entityManager->flush();

        $facture = new Facture();

        $textLibelle = "Reservation d'un véhicule de marque : " .$vehicule->getModele()->getMarque()." et de modèle ".$vehicule->getModele();

        $num_facture = $this->generateFacture($contrat->getId());
        $facture->setNumFacture($num_facture);
        $facture->setContrat($contrat);
        $facture->setLibelle($textLibelle);
        $facture->setDateFacture($today);
        $facture->setMontantTotalHtva($montant_totalHTVA);
        $facture->setMontantTotalTva($montant_total);
        $facture->setPaye(true);

        $entityManager->persist($facture);
        $entityManager->flush();

        $_SESSION["reservation"] = $reservation;
        $_SESSION["COUTTOT"] = $reservation->getMontantTotTva();
        $_SESSION["listeVar"] = "";
        $_SESSION["COUTTOT"] = "";
    }

    private function generateContrat()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $idUser = $this->getUser()->getId();
        $idUser = str_pad($idUser, 3, "0", STR_PAD_LEFT);
        $dateContrat = new \DateTime();
        $dateStrContrat = $dateContrat->format('Ymd');
        $lastContrat = $entityManager->getRepository(Contrat::class)->findOneBy(
            array(),
            array(
            'id' => 'DESC'
        ));
        if ($lastContrat){
            $lastNumContrat = $lastContrat->getNumContrat();

//            incrémenter les 5 derniers chiffres
            $lastNumContrat = substr($lastNumContrat, -5) + 1;
        }
        else{
            $lastNumContrat = 0;
        }
        $lastNumContrat = str_pad($lastNumContrat, 5, "0", STR_PAD_LEFT);
        $result = $idUser.'-'.$dateStrContrat.''.$lastNumContrat;
        return $result;
    }

    private function generateFacture($idContrat)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $idContrat = str_pad($idContrat, 5, "0", STR_PAD_LEFT);
        $lastFacture = $entityManager->getRepository(Facture::class)->findOneBy(
            array(),
            array(
            'id' => 'DESC'
        ));
        if ($lastFacture){
            $lastNumFacture = $lastFacture->getNumFacture();

//            incrémenter les 5 derniers chiffres
            $lastNumFacture = substr($lastNumFacture, -5) + 1;
        }
        else{
            $lastNumFacture = 0;
        }
        $lastNumFacture = str_pad($lastNumFacture, 5, "0", STR_PAD_LEFT);
        $result = $idContrat.'-MYCAAG-'.$lastNumFacture;
        return $result;
    }


    /**
     * @Route("/payerOnline", name="payerOnline")
     * @param Request $request
     * @param VehiculeRepository $t_vehicules
     * @param DisponibiliteRepository $t_disponibilites
     * @param AgenceRepository $t_agences
     * @param EtatRepository $t_etats
     * @return RedirectResponse|Response
     */
    public function payerOnline(Request $request, VehiculeRepository $t_vehicules, DisponibiliteRepository $t_disponibilites, AgenceRepository $t_agences, EtatRepository $t_etats)
    {
        $paiement = $request->get("paiement");

        if ($paiement == true){

            $this->saveReservation($t_disponibilites, $t_agences,  $t_vehicules, $t_etats, "online");

//            $reservation->setStatutRes(true);
//            $reservation->setToutPaye(true);

            $this->addFlash('success', 'Votre reservation à été enregistrée avec succès');
            return $this->redirectToRoute('home');
        }
        else{
            $this->addFlash('alert', 'Echec de paiement');
            return $this->render('reservation/payeOnline.html.twig', [
                'COUTTOT' => $_SESSION["COUTTOT"]
            ]);
        }
    }

    /**
     * @Route("/payerAgence", name="payerAgence", methods={"GET"})
     * @param Request $request
     * @param VehiculeRepository $t_vehicules
     * @param DisponibiliteRepository $t_disponibilites
     * @param AgenceRepository $t_agences
     * @param EtatRepository $t_etats
     * @return Response
     */
    public function payerAgence(Request $request, VehiculeRepository $t_vehicules, DisponibiliteRepository $t_disponibilites, AgenceRepository $t_agences, EtatRepository $t_etats): Response
    {
        $paiement = $request->get("paiement");

        if ($paiement == true){

            $this->saveReservation($t_disponibilites, $t_agences,  $t_vehicules, $t_etats, "agence");

            $this->addFlash('success', 'Votre reservation à été enregistrée avec succès. Votre acompte de ' .$_SESSION["reservation"]->getAcompte().' a bien été payé' );
            return $this->redirectToRoute('home');
        }
        else{
            $this->addFlash('alert', 'Echec de paiement');
            return $this->render('reservation/payeAgence.html.twig', [
                'COUTTOT' => $_SESSION["COUTTOT"]
            ]);
        }
    }

    /**
     * @Route("/paypal/{id}", name="paiementPaypal", methods={"GET","POST"})
     * @param Request $request
     * @param Reservation $reservation
     * @return Response
     */
    public function paiement(Request $request, Reservation $reservation): Response
    {
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'AYSq3RDGsmBLJE-otTkBtM-jBRd1TCQwFf9RGfwddNXWz0uFU9ztymylOhRS',     // ClientID
                'EGnHDxD_qRPdaLdZz8iCr8N7_MzF-YHPTkjs6NKYQvQSBngp4PTTVWkPZRbL'      // ClientSecret
            )
        );

        $payer = new \PayPal\Api\Payer();
        $payer->setPaymentMethod('paiement');

        $amount = new \PayPal\Api\Amount();
        $amount->setTotal($reservation->getMontantTotTva());
        $amount->setCurrency('EUR');

        $transaction = new \PayPal\Api\Transaction();
        $transaction->setAmount($amount);
//        $transaction->setDescription('');
        $redirectUrls = new \PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl("http://127.0.0.1:8000/payerOnline".$reservation->getId())
            ->setCancelUrl("https://example.com/your_cancel_url.html");

        $payment = new \PayPal\Api\Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($apiContext);
            echo $payment;

            echo "\n\nRedirect user to approval_url: " . $payment->getApprovalLink() . "\n";
        }
        catch (\PayPal\Exception\PayPalConnectionException $ex) {
            // This will print the detailed information on the exception.
            //REALLY HELPFUL FOR DEBUGGING
            echo $ex->getData();
        }
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/{id}", name="reservation_show", methods={"GET"})
     * @param Reservation $reservation
     * @return Response
     */
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reservation_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Reservation $reservation
     * @return Response
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
     * @param Request $request
     * @param Reservation $reservation
     * @return Response
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

    /**
     * @Route("/reservation_id/{id}", name="reservation_id")
     * @param $id
     * @param UserRepository $repository
     * @param Request $request
     * @param ReservationRepository $reservationRepository
     * @param AgenceRepository $t_agences
     * @return Response
     * @throws MpdfException
     */
    public function reservationPdfParId($id, UserRepository $repository, Request $request, ReservationRepository $reservationRepository, AgenceRepository $t_agences)
    {
        //        Convertir la date en français
        setlocale(LC_TIME, 'fr_FR.utf8', 'fra');

        //        Recherche la reservation en fonction du client connecté
        $reservation = $reservationRepository->find($id);
        $user_identity = $this->getUser();

        //        date de reservation
        $datRes = $reservation->getDateRes();
        $dRes = ucfirst(strftime('%A %e %B %Y', $datRes->getTimestamp()));

        //        date de debut de location du véhicule
        $dDebRes = $reservation->getDateDebutLoc();
        $dDebutRes = ucfirst(strftime('%A %e %B %Y', $dDebRes->getTimestamp()));

        //        date de fin de location du véhicule
        $dFRes = $reservation->getDateFinLoc();
        $dFinRes = ucfirst(strftime('%A %e %B %Y', $dFRes->getTimestamp()));

        //
        $catVehic = $reservation->getCategorie();
        $acompte = $reservation->getAcompte();
        if ($reservation->getTrancheAge()){
            $age = $reservation->getTrancheAge()." €";
        }else{
            $age = "Non";
        }
        if ($reservation->getCouvertureDommage()){
            $couvDom = $reservation->getCouvertureDommage()." €";
        }else{
            $couvDom = "Non";
        }
        if ($reservation->getCouvertureVol()){
            $couvVol = $reservation->getCouvertureVol()." €";
        }else{
            $couvVol = "Non";
        }
        $depart = $reservation->getAgence()->getVille();
        $retour = $t_agences->find($reservation->getAgenceRetour())->getVille();
        $coutTot = $reservation->getMontantTotTva();

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetHTMLHeader(
            "<h1 style='text-align: center; padding-top: 5%'><u>Reservation</u></h1>"
        );

        $mpdf->WriteHTML("
        <hr style='margin-top: 10%'>
            <table class='table-active' style='padding-top: 10%; padding-left: 13%; width: 85%'>
                <tr><td style='border: 1px solid #f58211;'><b>Numero de reservation</b></td> <td style='border: 1px solid #f58211; text-align: right'>$id</td></tr>
                <tr><td style='border: 1px solid #f58211;'><b>Nom du client</b></td> <td style='border: 1px solid #f58211; text-align: right'>$user_identity</tr>
                <tr><td style='border: 1px solid #f58211;'><b>Date de reservation</b></td> <td style='border: 1px solid #f58211; text-align: right'>$dRes</td></tr>
                <tr><td style='border: 1px solid #f58211;'><b>Date de debut de la location</b></td> <td style='border: 1px solid #f58211; text-align: right'>$dDebutRes</td></tr>
                <tr><td style='border: 1px solid #f58211;'><b>Date de fin de la location</b></td> <td style='border: 1px solid #f58211; text-align: right'>$dFinRes</td></tr> 
                <tr><td style='border: 1px solid #f58211;'><b>Agence de depart</b></td> <td style='border: 1px solid #f58211; text-align: right'>$depart</td></tr>
                <tr><td style='border: 1px solid #f58211;'><b>Agence de retour</b></td> <td style='border: 1px solid #f58211; text-align: right'>$retour</td></tr>
                <tr><td style='border: 1px solid #f58211;'><b>Catégorie du véhicule</b></td> <td style='border: 1px solid #f58211; text-align: right'>$catVehic</td></tr>
                <tr><td style='border: 1px solid #f58211;'><b>Acompte</b></td> <td style='border: 1px solid #f58211; text-align: right'>$acompte €</td></tr>
                <tr><td style='border: 1px solid #f58211;'><b>Couverture dommage</b></td> <td style='border: 1px solid #f58211; text-align: right'>$couvDom</td></tr>               
                <tr><td style='border: 1px solid #f58211;'><b>Couverture vol</b></td> <td style='border: 1px solid #f58211; text-align: right'>$couvVol</td></tr>                
                <tr><td style='border: 1px solid #f58211;'><b>Tranche age (25 - 69)</b></td> <td style='border: 1px solid #f58211; text-align: right'>$age</td></tr>               
                <tr><td style='border: 1px solid #f58211;'><b>Montant total (TTC)</b></td> <td style='border: 1px solid #f58211; text-align: right'>$coutTot €</td></tr>
            </table>
        </section>
        ");

        $mpdf->SetHTMLFooter('
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
