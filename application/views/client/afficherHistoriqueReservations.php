<div class="col-lg-12">
    <div class="container">
        <table class="table">
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
                    $datereserv = date_create($row->dateheure);
                    $datedepart = date_create($row->dateheuredepart);
                    echo'<tr>
                            <td>'. $row->noreservation .'</td>
                            <td>'. $datereserv->format('d/m/Y') .'</td>
                            <td>'. $row->nomportdepart .'</td>
                            <td>'. $row->nomportarrivee .'</td>
                            <td>'. $datedepart->format('d/m/Y') .'</td>
                            <td>'. $row->montanttotal .'</td>
                            <td>'; 
                            if($row->paye = 1){ echo "Oui"; } else { echo "Non"; } 
                            echo '</td>
                        </tr>';
                endforeach;
                echo $liensPagination;
                ?>
            </tbody>
        </table>
    </div>
</div>