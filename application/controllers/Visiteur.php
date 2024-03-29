<?php
class Visiteur extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('assets');
        $this->load->helper('date');
        $this->load->library("pagination");
        $this->load->library("session");
        $this->load->model("ModeleClient");
        $this->load->model("ModeleLiaison");
        $this->load->model("ModelePeriode");
        $this->load->model("ModeleCategorieType");
        $this->load->model("ModeleSecteur");
        $this->load->model("ModeleTraversee");
    } // fin __construct

    public function accueil()
    {
        $DataH['NomPage'] = 'Accueil';
        $this->load->view('templates/Entete', $DataH);
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
            $ClientRetourne = $this->ModeleClient->getClient($Identifiant, $MotdePasse);
            if (!($ClientRetourne == null))
            { // SUCCES : on a trouvé le client
                // On place l'identifiant dans une variable de session (= l'utilisateur est connecté)
                $this->session->identifiant = $ClientRetourne->mel;
                $this->session->nom = $ClientRetourne->nom;
                $this->session->prenom = $ClientRetourne->prenom;
                $this->session->noclient = $ClientRetourne->noclient;

                $DataH['NomPage'] = 'Connexion réussie !';
                $this->load->view('templates/Entete', $DataH);
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
        $DataH['NomPage'] = 'Déconnexion réussie !';
        $this->session->sess_destroy();
        $this->load->view('templates/Entete', $DataH);
        $this->load->view('visiteur/deconnexionReussie');
        $this->load->view('templates/PiedDePage');
    } // fin seDeconnecter

    public function creerCompte()
    {
        $DataH['NomPage'] = 'Créer un compte';
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
            $this->load->view('templates/Entete', $DataH);
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
            $ClientInsere = $this->ModeleClient->insertClient($DonneesAInserer);
            if (!($ClientInsere == null))
            { // SUCCES : on a inséré le client 
                $DataH['NomPage'] = 'Création réussie !';
                $this->load->view('templates/Entete', $DataH);
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
        $DataH['NomPage'] = 'Liste des liaisons pour chaque secteur';
        $Data['lesLiaisons'] = $this->ModeleLiaison->getLiaisonSec();

        $this->load->view('templates/Entete', $DataH);
        $this->load->view('visiteur/afficherLiaisons', $Data);
        $this->load->view('templates/PiedDePage');
    } // fin afficherLiaisons

    public function afficherTarifs($noliaison)
    {
        $DataH['NomPage'] = 'Tarifs pour une liaison';
        $dateDuJour = date('y-m-d');
        $Data['Liaison'] = $this->ModeleLiaison->getLiaison($noliaison);
        $Data['lesPeriodes'] = $this->ModelePeriode->getPeriodes($dateDuJour);
        $Data['lesCategoriesTypes'] = $this->ModeleCategorieType->getCategoriesTypes();
        $nombreTypesCategorie = $this->ModeleCategorieType->nombreTypesCategorie();
        $arrayNombre = array();
        foreach($nombreTypesCategorie as $nombreEtCategorie):
            $arrayNombre[$nombreEtCategorie->lettrecategorie] = $nombreEtCategorie->nombre;
        endforeach;
        $Data['nombreDeLignes'] = $arrayNombre;
        $Data['lesTarifs'] = $this->ModeleLiaison->getTarifs($noliaison);

        $this->load->view('templates/Entete', $DataH);
        $this->load->view('visiteur/afficherTarifs', $Data);
        $this->load->view('templates/PiedDePage');
    } // fin afficherTarifs

    public function afficherHorairesTraversees($nosecteur = null)
    {
        $DataH['NomPage'] = 'Horaires des traversées';
        $Data['lesSecteurs'] = $this->ModeleSecteur->getSecteurs();
        $Data['nosecteur'] = $nosecteur;
        $liaisonsDuSecteur = $this->ModeleLiaison->getLiaisonS($nosecteur);
        $Data['lesLiaisonsDuSecteur'] = [];
        foreach($liaisonsDuSecteur as $liaison):
            $Data['lesLiaisonsDuSecteur'][$liaison->noliaison] = $liaison->nomportdepart.' - '.$liaison->nomportarrivee;
        endforeach;

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('listeLiaisons', 'Liaison', 'required');
        $this->form_validation->set_rules('txtDate', 'Date', 'required');
        
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/Entete', $DataH);
            $this->load->view('visiteur/liste_secteurs', $Data);
            $this->load->view('visiteur/liste_liaisons_date', $Data);
            $this->load->view('templates/PiedDePage');
        }
        else
        {
            $Data['liaisonChoisie'] = $this->ModeleLiaison->getLiaison($this->input->post('listeLiaisons'));
            $Data['dateChoisie'] = $this->input->post('txtDate');

            $lesCategories = $this->ModeleCategorieType->getLesCategories();
            $lesTraverseesBateaux = $this->ModeleTraversee->getLesTraverseesBateaux($this->input->post('listeLiaisons'), date_create($Data['dateChoisie'])->format('Y-m-d'));
            
            $table = array();           
            foreach($lesTraverseesBateaux as $traversee):
                $heuredepart = date_create($traversee->dateheuredepart);
                $ligne = array('notraversee' => $traversee->notraversee, 'heuredepart' => $heuredepart->format('H:i'), 'nombateau' => $traversee->nombateau);
                foreach($lesCategories as $uneCategorie):
                    $CapMax = $this->ModeleTraversee->getCapaciteMaximale($traversee->notraversee, $uneCategorie->lettrecategorie); //Capacité max de la catégorie
                    $QuantEnr = $this->ModeleTraversee->getQuantiteEnregistree($traversee->notraversee, $uneCategorie->lettrecategorie); //Quantité enregistrée pour cette catégorie de la traversée

                    if ($CapMax == null) 
                    {$CapMax = False;}
                    else 
                    {$CapMax = $CapMax->capacitemax; };

                    if ($QuantEnr == null) 
                    {$QuantEnr = False;}
                    else 
                    {$QuantEnr = $QuantEnr->quantiteenregistree; };
                    
                    $placesDispo = intval($CapMax) - intval($QuantEnr);
                    $ligne[$uneCategorie->lettrecategorie] = $placesDispo;
                endforeach;
                array_push($table, $ligne);
            endforeach;
            $Data['table'] = $table;
            $Data['lesCategories'] = $lesCategories;

            $this->load->view('templates/Entete', $DataH);
            $this->load->view('visiteur/liste_secteurs', $Data);
            $this->load->view('visiteur/liste_liaisons_date', $Data);
            $this->load->view('visiteur/tableau_horaires_traversees', $Data);
            $this->load->view('templates/PiedDePage');
        }
    } // fin afficherHorairesTraversees
}