<div style="">
Sélectionner la liaison, et la date souhaitées
<?php
  echo validation_errors();

  echo form_open('visiteur/afficherTraversees/'.$nosecteur);
  echo form_dropdown('listeLiaisons', $lesLiaisonsDuSecteur, 'large');
  echo form_input('txtDate', set_value('txtDate'), 'small');
  

  echo form_submit('submit', 'Afficher les traversées');
  echo form_close();
?>
</div>