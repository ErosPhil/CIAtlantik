<table border = 1>
    <thead>
        <tr>
            <th colspan="1">n° réservation</th>
            <th colspan="1">Date réservation</th>
            <th colspan="1">Départ</th>
            <th colspan="1">Arrivée</th>
            <th colspan="1">Date départ</th>
            <th colspan="1">Total</th>
            <th colspan="1">Payé</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($lesReservations as $row):
            echo'<tr>
                    <td>'. $row->noreservation .'</td>
                    <td>'. $row->dateheure .'</td>
                    <td>'. $row->nomportdepart .'</td>
                    <td>'. $row->nomportarrivee .'</td>
                    <td>'. $row->dateheuredepart .'</td>
                    <td>'. $row->montanttotal .'</td>
                    <td>'; 
                    if($row->paye = 1){ echo "Oui"; } else { echo "Non"; } 
                    echo '</td>
                </tr>';
        endforeach ?>
    </tbody>
</table>
