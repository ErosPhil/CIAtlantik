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
                    foreach($ligne as $cellule):
                        echo "<td>".$cellule."</td>";
                    endforeach;
                    echo "</tr>";
                endforeach;
            ?>
        </tbody>
    </table>
<?php print_r($table); ?>