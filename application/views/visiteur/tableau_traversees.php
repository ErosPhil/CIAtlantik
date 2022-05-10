<?php
    echo $liaisonChoisie->nomportdepart.' - '.$liaisonChoisie->nomportarrivee.'.<br>Traversées pour le '.$dateChoisie.'. Sélectionner la traversée souhaitée';
?>
<table border = 1>
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
                    echo "<td>"?> <a href="<?php echo site_url('visiteur/accueil/') ?>"> <?php echo $ligne[0]."</a></td>";
                    echo "<td>".$ligne[1]."</td><td>".$ligne[2]."</td>";
                    $x=3;
                    foreach($lesCategories as $uneCategorie):
                        echo "<td>".$ligne[$x]."</td>";
                        $x++;
                    endforeach;
                echo "</tr>";
            endforeach;
        ?>
    </tbody>
</table>