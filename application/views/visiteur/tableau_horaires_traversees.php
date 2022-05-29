<div class="row">
    <?php
        echo $liaisonChoisie->nomportdepart.' - '.$liaisonChoisie->nomportarrivee.'.<br>Traversées pour le '.date_create($dateChoisie)->format('d/m/Y').'. Sélectionner la traversée souhaitée';
    ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="3">Traversée</th>
                <th colspan="100%">Places disponibles par catégorie</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>N°</td><td>Heure</td><td>Bateau</td>
                <?php 
                    foreach($lesCategories as $uneCategorie):
                        echo "<td>".$uneCategorie->lettrecategorie."<br>".$uneCategorie->libelle."</td>";
                    endforeach;
                ?>
            </tr>
            <?php
                foreach($table as $ligne):
                    echo "<tr>";
                        echo "<td>"?> <a href="<?php echo site_url('client/reserverTraversee/'.$ligne['notraversee']) ?>"> <?php echo $ligne['notraversee']."</a></td>";
                        echo "<td>".$ligne['heuredepart']."</td><td>".$ligne['nombateau']."</td>";
                        $x=3;
                        foreach($lesCategories as $uneCategorie):
                            $lettre = $uneCategorie->lettrecategorie;
                            echo "<td>".$ligne[$lettre]."</td>";
                            $x++;
                        endforeach;
                    echo "</tr>";
                endforeach;
            ?>
        </tbody>
    </table>
</div>