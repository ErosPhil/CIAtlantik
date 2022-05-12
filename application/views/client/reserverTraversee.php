<?php
echo "Liaison ".$liaison->nomportdepart." - ".$liaison->nomportarrivee."<br> Traversée n°".$traversee->notraversee." le ".$dateheuredepart->format('d/m/Y')." à ".$dateheuredepart->format('H').'h'.$dateheuredepart->format('i');
echo "<br>Saisir les informations relatives à la réservation <br><br> Nom : ".$client->nom."<br> Adresse : ".$client->adresse."<br> Code Postal : ".$client->codepostal." Ville : ".$client->ville;
?>
<table border = 1>
    <thead>
        <tr>
            <th></th>
            <th>Tarif en €</th>
            <th>Quantité</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php 

            ?>
        </tr>
    </tbody>
</table>