<table border = 1>
    <thead>
        <tr>
            <th colspan="1" rowspan="2">Secteur</th>
            <th colspan="4">Liaison</th>
        </tr>
        <tr>
            <td colspan="1">Code Liaison</td>
            <td colspan="1">Distance en milles marin</td>
            <td colspan="1">Port de départ</td>
            <td colspan="1">Port d'arrivée</td>
        </tr>
    </thead>
    <tbody>
        <?php
        $secteur_courant = "";
        foreach($lesLiaisons as $row):
            echo '<tr>';
            if ($row->nomsecteur==$secteur_courant)
            {
                echo '<td></td>';
            }
            else
            {
                echo '<td>'. $row->nomsecteur .'</td>';
                $secteur_courant = $row->nomsecteur;
            }
            echo '<td>'?> <a href="<?php echo site_url('visiteur/afficherTarifs/'.$row->codeliaison)?>"> <?php echo $row->codeliaison .'</a></td><td>'. $row->distance .'</td><td>'. $row->portdepart .'</td><td>'. $row->portarrivee .'</td></tr>';
        endforeach ?>
    </tbody>
</table>