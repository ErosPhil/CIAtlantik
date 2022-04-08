<?php
  echo validation_errors(); // mise en place de la validation
  /* set_value : en cas de non validation les données déjà 
  saisies sont réinjectées dans le formulaire */

  echo form_open('visiteur/seConnecter');
  // creation d'un label devant la zone de saisie
  echo form_label('Identifiant','txtIdentifiant');
  echo form_input('txtIdentifiant', set_value('txtIdentifiant'));    

  echo form_label('Mot de passe','txtMotDePasse');
  echo form_password('txtMotDePasse', set_value('txtMotDePasse'));    

  echo form_submit('submit', 'Se connecter');
  echo form_close();
?>