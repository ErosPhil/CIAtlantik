<?php
class Visiteur extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('assets'); // helper 'assets' ajouté a Application
        $this->load->library("pagination");
        $this->load->library("session");
    }

    public function accueil()
    {
        $Data['NomPage'] = 'Accueil';
        $this->load->view('templates/Entete', $Data);
        $this->load->view('visiteur/accueil');
        $this->load->view('templates/PiedDePage');
    }

    public function seConnecter()
    {
        $Data['NomPage'] = 'Se Connecter';
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('txtIdentifiant', 'Identifiant', 'required');
        $this->form_validation->set_rules('txtMotDePasse', 'Mot de passe', 'required');

        if ($this->form_validation->run() === FALSE)
        { // ECHEC VALIDATION FORMULAIRE ou PREMIER APPEL FORMULAIRE
            $this->load->view('templates/Entete', $Data);
            $this->load->view('visiteur/seConnecter');
            $this->load->view('templates/PiedDePage');
        }
        else
        { // FORULAIRE VALIDE
            $Identifiant = $this->input->post('txtIdentifiant');
            $MotdePasse = $this->input->post('txtMotDePasse');
            $ClientRetourne = $this->ModeleClient->retournerClient($Identifiant, $MotdePasse);
        }
    }

    public function seDeConnecter() 
    { // destruction de la session = déconnexion
        $this->session->sess_destroy();
    }
}