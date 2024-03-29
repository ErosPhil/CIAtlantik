<?php
class Client extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('assets');
        $this->load->helper('date');
        $this->load->library("pagination");
        $this->load->library("session");
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
                $this->session->nom = $DonneesAInserer['nom'];
                $this->session->prenom = $DonneesAInserer['prenom'];
                $this->session->identifiant = $DonneesAInserer['mel'];
                $DataH['NomPage'] = 'Modification effectuée';
                $this->load->view('templates/Entete', $DataH);
                $this->load->view('client/modificationReussie');
                $this->load->view('templates/PiedDePage');
            }
            else
            { // ECHEC : on n'a pas pu modifier les informations de la BDD
                $this->load->view('templates/Entete');
                $this->load->view('client/modifierInformations', $Data);
                $this->load->view('templates/PiedDePage');
            }
        }
    } // fin modifierInformations

    public function afficherHistoriqueReservations()
    {
        $DataH['NomPage'] = 'Historique des réservations';
        
        $config = array();
        $config["base_url"] = site_url('client/afficherHistoriqueReservations');
        $config["total_rows"] = intval($this->ModeleReservation->nombreDeReservations($this->session->noclient)->nombre);
        $config["per_page"] = 4;
        $config["uri_segment"] = 3; /* le n° de la page sera placé sur le segment n°3 de URI*/ 
        
        $config['first_link'] = '1';
        $pageMax = $config['total_rows'] / $config["per_page"];
        $config['last_link'] = $pageMax;
        $config['next_link'] = '>>';
        $config['prev_link'] = '<<';

        $this->pagination->initialize($config);

        $noPage = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0; 
        /* on récupère le n° de la page - segment 3 - si ce segment est vide, cas du premier appel 
        de la méthode, on affecte 0 à $noPage */
        
        $Data["lesReservations"] = $this->ModeleReservation->retournerReservationsLimite($config["per_page"], $noPage, $this->session->noclient);
        $Data["liensPagination"] = $this->pagination->create_links();

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

        foreach($Data['TypesEtTarifs'] as $ligne):
            $this->form_validation->set_rules('txt'.$ligne->lettrecategorie.$ligne->notype, $ligne->lettrecategorie.$ligne->notype, 'integer');
        endforeach;

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/Entete', $DataH);
            $this->load->view('client/reserverTraversee', $Data);
            $this->load->view('templates/PiedDePage');
        }
        else
        {
            $lesCategories = $this->ModeleCategorieType->getLesCategories();
            $vide = True;
            $possible = True;
            foreach($lesCategories as $uneCategorie):
                $CapMax = $this->ModeleTraversee->getCapaciteMaximale($notraversee, $uneCategorie->lettrecategorie); //Capacité max de la catégorie
                $QuantEnr = $this->ModeleTraversee->getQuantiteEnregistree($notraversee, $uneCategorie->lettrecategorie); //Quantité enregistrée pour cette catégorie de la traversée
                if($CapMax != null)
                {
                    $quantiteAAjouter = 0;
                    
                    foreach($Data['TypesEtTarifs'] as $uneCategorieType):
                        $quantiteEnregistree = $this->input->post('txt'.$uneCategorieType->lettrecategorie.$uneCategorieType->notype); //Quantité que l'on souhaite enregistrer depuis le formulaire
                        if($uneCategorieType->lettrecategorie == $uneCategorie->lettrecategorie && $quantiteEnregistree != null)
                        {
                            $quantiteAAjouter += intval($quantiteEnregistree);
                            $vide = False;
                        }
                    endforeach;
                    $placesDispo = intval($CapMax->capacitemax) - intval($QuantEnr->quantiteenregistree) - $quantiteAAjouter;
                    if($placesDispo < 0) { $possible = False; }
                }
            endforeach;
            
            if($possible && !($vide))
            {
                $DonneesAInserer = array();
                $coutTotal = 0;
                foreach($Data['TypesEtTarifs'] as $ligne):
                    $quantiteEnregistree = $this->input->post('txt'.$ligne->lettrecategorie.$ligne->notype); //Quantité que l'on souhaite enregistrer depuis le formulaire
                    if(!($quantiteEnregistree == null))
                    {
                        $coutTotal += $ligne->tarif * $quantiteEnregistree;
                    }
                endforeach;

                $DonneesReservation = array(
                    'notraversee' => $notraversee,
                    'noclient' => $this->session->noclient,
                    'dateheure' => date('y-m-d h:i:s'),
                    'montanttotal' => $coutTotal,
                    'paye' => true,
                    'modereglement' => null
                );
                $Data['lastInsertId'] = $this->ModeleReservation->reserver($DonneesReservation);

                if($Data['lastInsertId'] != false)
                { // SUCCES
                    $enregistrements = array();
                    
                    foreach($Data['TypesEtTarifs'] as $ligne):
                        $quantiteEnregistree = $this->input->post('txt'.$ligne->lettrecategorie.$ligne->notype);
                        if($quantiteEnregistree == null){$quantiteEnregistree = 0;}
                        $DonneesEnregistrement = array(
                            'noreservation' => $Data['lastInsertId'],
                            'lettrecategorie' => $ligne->lettrecategorie,
                            'notype' => $ligne->notype,
                            'quantite' => $quantiteEnregistree
                        );
                        $enregistrements[$ligne->lettrecategorie.$ligne->notype] = $this->ModeleReservation->enregistrer($DonneesEnregistrement);
                    endforeach;
                    
                    redirect('/client/compte_rendu/'.$notraversee.'/'.$Data['lastInsertId']);
                }
                else
                { // ECHEC
                    $Data['message'] = "Erreur lors de l'insertion de la réservation";
                    $this->load->view('templates/Entete');
                    $this->load->view('client/reserverTraversee', $Data);
                    $this->load->view('templates/PiedDePage');
                }
            }
            else
            {
                $Data['message'] = "Enregistrement impossible: il ne reste pas assez de places pour une des catégories ou vous n'avez pas renseigné au minimum 1 champs";
                $this->load->view('templates/Entete');
                $this->load->view('client/reserverTraversee', $Data);
                $this->load->view('templates/PiedDePage');
            }
        }
    } // fin reserverTraversee

    public function compte_rendu($notraversee, $noReservation)
    {
        
            $DataH['NomPage'] = 'Compte-rendu de la réservation';
        
            $Data['traversee'] = $this->ModeleTraversee->getTraversee($notraversee);
            $Data['liaison'] = $this->ModeleLiaison->getLiaison($Data['traversee']->noliaison);
            $Data['dateheuredepart'] = date_create($Data['traversee']->dateheuredepart);
            $Data['client'] = $this->ModeleClient->getClientN($this->session->noclient);
            $Data['reservation'] = $this->ModeleReservation->getReservation($noReservation);
            $Data['enregistrements'] = $this->ModeleReservation->getEnregistrements($noReservation);

            $this->load->view('templates/Entete', $DataH);
            $this->load->view('client/compte_rendu', $Data);
            $this->load->view('templates/PiedDePage');
    } // fin compte_rendu
}
?>