
<?php
echo "Liaison ".$liaison->nomportdepart." - ".$liaison->nomportarrivee."<br> Traversée n°".$traversee->notraversee." le ".$dateheuredepart->format('d/m/Y')." à ".$dateheuredepart->format('H').'h'.$dateheuredepart->format('i');
echo "<br><br>".$client->nom." ".$client->adresse." ".$client->codepostal." ".$client->ville;
?>
