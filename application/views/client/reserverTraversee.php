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
        <?php
        echo validation_errors();
        echo form_open('client/compte_rendu/'.$traversee->notraversee);
        foreach($TypesEtTarifs as $ligne):
            echo "<tr><td>".$ligne->libelle."</td><td>".$ligne->tarif."</td><td>".form_input('txt'.$ligne->lettrecategorie.$ligne->notype, set_value('txt'.$ligne->lettrecategorie.$ligne->notype))."</td></tr>";
        endforeach;
        ?>
    </tbody>
    <br>
    <?php
    echo form_submit('submit', 'Valider-Acheter');
    echo form_close(); 
    ?>
</table>