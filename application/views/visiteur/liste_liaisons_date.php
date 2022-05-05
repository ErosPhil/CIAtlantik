<div style="position: absolute; left:300px; top:100px">
<?php
  echo validation_errors();

  echo form_open('visiteur/afficherTraversees/'.$nosecteur);
  echo form_label('Sélectionner la liaison, et la date souhaitées','txtLiaisonDate');
  echo form_dropdown('listeLiaisons', [], 'large');
  echo form_input('txtDate', set_value('txtDate'), 'small');
  

  echo form_submit('submit', 'Afficher les traversées');
  echo form_close();
?>
</div>