<div class="container">
    <div class="row justify-content-center">
        <h1>Modifier les informations relatives au compte</h1>
    </div>
</div>
<div class="col-lg-12">
    <div class="container">
        <div style="margin-right: 43%; margin-left: 43%">
            <?php
                echo validation_errors(); // mise en place de la validation
                /* set_value : en cas de non validation les données déjà 
                saisies sont réinjectées dans le formulaire*/

                echo form_open('client/modifierInformations');
                echo form_label('Nom','txtNom');
                echo form_input('txtNom', $Nom);

                echo form_label('Prénom','txtPrenom');
                echo form_input('txtPrenom', $Prenom);

                echo form_label('Adresse','txtAdresse');
                echo form_input('txtAdresse', $Adresse);
                
                echo form_label('Ville','txtVille');
                echo form_input('txtVille', $Ville);
                
                echo form_label('Code Postal','txtCodePostal');
                echo form_input('txtCodePostal', $CodePostal);

                echo form_label('Téléphone Fixe','txtTelFixe');
                echo form_input('txtTelFixe', $TelFixe);
                
                echo form_label('Téléphone Portable','txtTelPortable');
                echo form_input('txtTelPortable', $TelPortable);
                
                echo form_label('Mel','txtMel');
                echo form_input('txtMel', $Mel);

                echo form_label('Mot de passe','txtMotDePasse');
                echo form_password('txtMotDePasse', set_value('txtMotDePasse'));

                echo form_submit('submit', 'Valider');
                echo form_close();
            ?>
        </div>
    </div>
</div>