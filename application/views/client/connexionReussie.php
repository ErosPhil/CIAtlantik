<div class="col-lg-12">
    <div class="container">
        <?php 
            echo '<h2>Connexion réussie !</h2>';
            echo '<p>Bienvenue '.$this->session->prenom.' '.$this->session->nom.' !</p>';
            echo anchor('visiteur/accueil',"Retour à la page d'accueil");
        ?>
    </div>
</div>