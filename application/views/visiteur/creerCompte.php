<div class="col-lg-12">
    <div class="container">
        <div style="margin-right: 41%; margin-left: 41%">
            <?php
                echo validation_errors(); // mise en place de la validation
                /* set_value : en cas de non validation les données déjà 
                saisies sont réinjectées dans le formulaire*/

                echo form_open('visiteur/creerCompte');
                echo form_label('Nom','txtNom');
                echo form_input('txtNom', set_value('txtNom'));    

                echo form_label('Prénom','txtPrenom');
                echo form_input('txtPrenom', set_value('txtPrenom'));

                echo form_label('Adresse','txtAdresse');
                echo form_input('txtAdresse', set_value('txtAdresse'));
                
                echo form_label('Ville','txtVille');
                echo form_input('txtVille', set_value('txtVille'));
                
                echo form_label('Code Postal','txtCodePostal');
                echo form_input('txtCodePostal', set_value('txtCodePostal'));

                echo form_label('Téléphone Fixe','txtTelFixe');
                echo form_input('txtTelFixe', set_value('txtTelFixe'));
                
                echo form_label('Téléphone Portable','txtTelPortable');
                echo form_input('txtTelPortable', set_value('txtTelPortable'));
                
                echo form_label('Mel','txtMel');
                echo form_input('txtMel', set_value('txtMel'));

                echo form_label('Mot de passe','txtMotDePasse');
                echo form_password('txtMotDePasse', set_value('txtMotDePasse'));    

                echo form_submit('submit', 'Valider');
                echo form_close();

                echo "Vous avez déjà un compte ? ".anchor('visiteur/seConnecter',"Connectez-vous").'.';
            ?>
        </div>
    </div>
</div>