<?php
class Client extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library("session");
        $this->load->helper('url');
        $this->load->helper('assets');
        $this->load->helper('date');
        $this->load->library("pagination");
        $this->load->model("ModeleClient");
        $this->load->model("ModeleReservation");
        $this->load->model("ModeleTraversee");
        $this->load->model("ModeleLiaison");
        $this->load->model("ModeleCategorieType");
        $this->load->model("ModelePeriode");

        if (is_null($this->session->identifiant))
        {
            redirect('/visiteur/seConnecter');
        }
    } // fin __construct

    public function modifierInformations()
    {
        $DataH['NomPage'] = 'Modifier les informations du compte';
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('txtMel', 'Mel', 'required');
        $this->form_validation->set_rules('txtMotDePasse', 'Mot de passe', 'required');
        $this->form_validation->set_rules('txtNom', 'Nom', 'required');
        $this->form_validation->set_rules('txtPrenom', 'Prénom', 'required');
        $this->form_validation->set_rules('txtAdresse', 'Adresse', 'required');
        $this->form_validation->set_rules('txtVille', 'Ville', 'required');
        $this->form_validation->set_rules('txtCodePostal', 'Code Postal', 'required', 'integer');
        $this->form_validation->set_rules('txtTelPortable', 'Téléphone Mobile', 'integer');
        $this->form_validation->set_rules('txtTelFixe', 'Téléphone Fixe', 'integer');

        $Client = $this->ModeleClient->getClientN($this->session->noclient);

        if ($this->form_validation->run() === FALSE)
        { // ECHEC VALIDATION FORMULAIRE ou PREMIER APPEL FORMULAIRE
            $Data['Nom'] = $Client->nom;
            $Data['Prenom'] = $Client->prenom;
            $Data['Adresse'] = $Client->adresse;
            $Data['Ville'] = $Client->ville;
            $Data['CodePostal'] = $Client->codepostal;
            $Data['TelFixe'] = $Client->telephonefixe;
            $Data['TelPortable'] = $Client->telephonemobile;
            $Data['Mel'] = $Client->mel;
            
            $this->load->view('templates/Entete', $DataH);
            $this->load->view('client/modifierInformations', $Data);
            $this->load->view('templates/PiedDePage');
        }
        else
        { // FORMULAIRE VALIDE
            $DonneesAInserer = array(
                'nom' => $this->input->post('txtNom'),
                'prenom' => $this->input->post('txtPrenom'),
                'adresse' => $this->input->post('txtAdresse'),
                'codepostal' => $this->input->post('txtCodePostal'),
                'ville' => $this->input->post('txtVille'),
                'telephonefixe' => $this->input->post('txtTelFixe'),
                'telephonemobile' => $this->input->post('txtTelPortable'),
                'mel' => $this->input->post('txtMel'),
                'motdepasse' => $this->input->post('txtMotDePasse')
            );
            $Modifications = $this->ModeleClient->modifierInformations($DonneesAInserer, $this->session->noclient);
            if (!($Modifications == null))
            { // SUCCES : on a modifié les informations du client dans la BDD
                $DataH['NomPage'] = 'Modification effectuée';
                $this->load->view('templates/Entete', $DataH);
                $this->load->view('client/modificationReussie');
                $this->load->view('templates/PiedDePage');
            }
            else
            { // ECHEC : on n'a pas pu modifier les informations de la BDD
                $this->load->view('templates/Entete');
                $this->load->view('client/modifierInformations');
                $this->load->view('templates/PiedDePage');
            }
        }
    } // fin modifierInformations

    public function afficherHistoriqueReservations()
    {
        $DataH['NomPage'] = 'Historique des réservations';
        $Data['lesReservations'] = $this->ModeleReservation->getReservations($this->session->noclient);

        $this->load->view('templates/Entete', $DataH);
        $this->load->view('client/afficherHistoriqueReservations', $Data);
        $this->load->view('templates/PiedDePage');
    } // fin afficherHistoriqueReservations

    public function reserverTraversee($notraversee)
    {
            $DataH['NomPage'] = 'Réserver un traversée';

            $Data['traversee'] = $this->ModeleTraversee->getTraversee($notraversee);
            $Data['liaison'] = $this->ModeleLiaison->getLiaison($Data['traversee']->noliaison);
            $Data['client'] = $this->ModeleClient->getClientN($this->session->noclient);
            $Data['dateheuredepart'] = date_create($Data['traversee']->dateheuredepart);
            $datedepart = date_create($Data['traversee']->dateheuredepart)->format('Y-m-d');
            $noperiode = $this->ModelePeriode->getPeriodePourDate($datedepart);
            $Data['TypesEtTarifs'] = $this->ModeleCategorieType->getLesTypesAvecTarifs($Data['traversee']->noliaison, $noperiode);
            
            $this->load->helper('form');
            $this->load->library('form_validation');

            $this->load->view('templates/Entete', $DataH);
            $this->load->view('client/reserverTraversee', $Data);
            $this->load->view('templates/PiedDePage');
    } // fin reserverTraversee

    public function compte_rendu($notraversee)
    {
        if ($this->form_validation->run() === FALSE)
        {
            redirect('/client/reserverTraversee/'.$notraversee);
        }
        else
        {
            $DataH['NomPage'] = 'Compte-rendu de la réservation';
        
            $Data['traversee'] = $this->ModeleTraversee->getTraversee($notraversee);
            $Data['liaison'] = $this->ModeleLiaison->getLiaison($Data['traversee']->noliaison);
            $Data['dateheuredepart'] = date_create($Data['traversee']->dateheuredepart);
            $Data['client'] = $this->ModeleClient->getClientN($this->session->noclient);
            
            $this->load->view('templates/Entete', $DataH);
            $this->load->view('client/compte_rendu', $Data);
            $this->load->view('templates/PiedDePage');
        }
    }
}
?>