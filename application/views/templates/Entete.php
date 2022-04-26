<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Atlantik - <?php echo $NomPage ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- BOOTSTRAP -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        
    </head>
    <body>
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
            <a class="navbar-brand" href="<?php echo site_url('visiteur/accueil') ?>">
                <img src="<?php echo img_url('Atlantik.jpg')?>" alt="Logo" style="width:60px;">
            </a>
            <ul class="navbar-nav">
                <?php if(!is_null($this->session->identifiant)): ?>
                <!-- Si utilisateur connecté-->
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('client/modifierInformations')?>"><?php echo $this->session->prenom.' '.$this->session->nom;?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('visiteur/seDeconnecter')?>">Se déconnecter</a>
                    </li>
                <?php else: ?>
                <!-- Sinon (pas connecté)-->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                        Compte
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?php echo site_url('visiteur/seConnecter') ?>">Se connecter</a>
                        <a class="dropdown-item" href="<?php echo site_url('visiteur/creerCompte') ?>">Créer un compte</a>
                    </div>
                </li>
                <?php endif; ?>
            </ul>
        </nav>