
<?php
echo "Liaison ".$liaison->nomportdepart." - ".$liaison->nomportarrivee."<br> Traversée n°".$traversee->notraversee." le ".$dateheuredepart->format('d/m/Y')." à ".$dateheuredepart->format('H').'h'.$dateheuredepart->format('i');
echo "<br>Réservation enregistrée sous le n° ".$reservation->noreservation;
echo "<br>".$client->nom." ".$client->adresse." ".$client->codepostal." ".$client->ville;
foreach($enregistrements as $enr)
{
    if($enr->quantite > 0)
    { echo "<br>".$enr->libelle." : ".$enr->quantite; }
}
echo "<br>Montant total à régler : ".$reservation->montanttotal;
if($reservation->modereglement != NULL)
{ echo "<br>Modalités de règlement : ".$reservation->modereglement; }
else
{ echo "<br>Modalités de règlement non renseignées"; }
?>