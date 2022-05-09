<?php
class Client extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library("session");
        $this->load->helper('url');
        $this->load->helper('assets');
        $this->load->library("pagination");
        $this->load->model("ModeleClient");
        $this->load->model("ModeleReservation");
    } // fin __construct

    public function modifierInformations()
    {
        $Data['NomPage'] = 'Modifier les informations du compte';
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
            
            $this->load->view('templates/Entete', $Data);
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
                $Data['NomPage'] = 'Modification effectuée';
                $this->load->view('templates/Entete', $Data);
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
        $Data['NomPage'] = 'Historique des réservations';
        $Data['lesReservations'] = $this->ModeleReservation->getReservations($this->session->noclient);

        $this->load->view('templates/Entete', $Data);
        $this->load->view('client/afficherHistoriqueReservations', $Data);
        $this->load->view('templates/PiedDePage');
    } // fin afficherHistoriqueReservations
}
?>