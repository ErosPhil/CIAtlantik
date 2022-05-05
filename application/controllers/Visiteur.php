<?php
class Visiteur extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('assets');
        $this->load->library("pagination");
        $this->load->library("session");
        $this->load->model("ModeleClient");
        $this->load->model("ModeleLiaison");
        $this->load->model("ModelePeriode");
        $this->load->model("ModeleCategorieType");
        $this->load->model("ModeleSecteur");
        $this->load->helper('date');
    } // fin __construct

    public function accueil()
    {
        $Data['NomPage'] = 'Accueil';
        $this->load->view('templates/Entete', $Data);
        $this->load->view('visiteur/accueil');
        $this->load->view('templates/PiedDePage');
    } // fin accueil

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
            if (!($ClientRetourne == null))
            { // SUCCES : on a trouvé le client
                // On place l'identifiant dans une variable de session (= l'utilisateur est connecté)
                $this->session->identifiant = $ClientRetourne->mel;
                $this->session->nom = $ClientRetourne->nom;
                $this->session->prenom = $ClientRetourne->prenom;
                $this->session->noclient = $ClientRetourne->noclient;

                $Data['NomPage'] = 'Connexion réussie !';
                $this->load->view('templates/Entete', $Data);
                $this->load->view('client/connexionReussie');
                $this->load->view('templates/PiedDePage');
            }
            else
            { // ECHEC : on n'a pas trouvé le client dans la BDD; on renvoie le formulaire
                $this->load->view('templates/Entete');
                $this->load->view('visiteur/seConnecter');
                $this->load->view('templates/PiedDePage');
            }
        }
    } // fin seConnecter

    public function seDeConnecter() 
    { // destruction de la session = déconnexion
        $Data['NomPage'] = 'Déconnexion réussie !';
        $this->session->sess_destroy();
        $this->load->view('templates/Entete', $Data);
        $this->load->view('visiteur/deconnexionReussie');
        $this->load->view('templates/PiedDePage');
    } // fin seDeconnecter

    public function creerCompte()
    {
        $Data['NomPage'] = 'Créer un compte';
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

        if ($this->form_validation->run() === FALSE)
        { // ECHEC VALIDATION FORMULAIRE ou PREMIER APPEL FORMULAIRE
            $this->load->view('templates/Entete', $Data);
            $this->load->view('visiteur/creerCompte');
            $this->load->view('templates/PiedDePage');
        }
        else
        { // FORULAIRE VALIDE
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
            $ClientInsere = $this->ModeleClient->insererClient($DonneesAInserer);
            if (!($ClientInsere == null))
            { // SUCCES : on a inséré le client 
                $Data['NomPage'] = 'Création réussie !';
                $this->load->view('templates/Entete', $Data);
                $this->load->view('visiteur/creationReussie');
                $this->load->view('templates/PiedDePage');
            }
            else
            { // ECHEC : on n'a pas pu insérer le client
                $this->load->view('templates/Entete');
                $this->load->view('visiteur/creerCompte');
                $this->load->view('templates/PiedDePage');
            }
        }
    } // fin creerCompte

    public function afficherLiaisons()
    {
        $Data['NomPage'] = 'Liste des liaisons pour chaque secteur';
        $Data['lesLiaisons'] = $this->ModeleLiaison->retournerLiaisons();

        $this->load->view('templates/Entete', $Data);
        $this->load->view('visiteur/afficherLiaisons', $Data);
        $this->load->view('templates/PiedDePage');
    } // fin afficherLiaisons

    public function afficherTarifs($noliaison)
    {
        $Data['NomPage'] = 'Tarifs pour une liaison';
        $dateDuJour = date('y-m-d');
        $Data['Liaison'] = $this->ModeleLiaison->retournerLiaisonActuelle($noliaison);
        $Data['lesPeriodes'] = $this->ModelePeriode->retournerPeriodes($dateDuJour);
        $Data['lesCategoriesTypes'] = $this->ModeleCategorieType->retournerCategoriesTypes();
        $nombreTypesCategorie = $this->ModeleCategorieType->nombreTypesCategorie();
        $arrayNombre = array();
        foreach($nombreTypesCategorie as $nombreEtCategorie):
            $arrayNombre[$nombreEtCategorie->lettrecategorie] = $nombreEtCategorie->nombre;
        endforeach;
        $Data['nombreDeLignes'] = $arrayNombre;
        $Data['lesTarifs'] = $this->ModeleLiaison->retournerTarifs($noliaison);

        $this->load->view('templates/Entete', $Data);
        $this->load->view('visiteur/afficherTarifs', $Data);
        $this->load->view('templates/PiedDePage');
    }

    public function afficherTraversees($nosecteur = null)
    {
        $Data['NomPage'] = 'Horaires des traversées';
        $Data['lesSecteurs'] = $this->ModeleSecteur->retournerSecteurs();
        $Data['nosecteur'] = $nosecteur;

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('listeLiaisons', 'Liaison', 'required');
        $this->form_validation->set_rules('txtDate', 'Date', 'required');
        
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/Entete', $Data);
            $this->load->view('visiteur/liste_secteurs', $Data);
            $this->load->view('visiteur/liste_liaisons_date', $Data);
            $this->load->view('templates/PiedDePage');
        }
        else
        {
            $this->load->view('templates/Entete', $Data);
            $this->load->view('visiteur/liste_secteurs', $Data);
            $this->load->view('visiteur/liste_liaisons_date', $Data);
            $this->load->view('visiteur/tableau_traversees', $Data);
            $this->load->view('templates/PiedDePage');
        }
        
    }
}