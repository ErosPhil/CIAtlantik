<table border = 1>
    <thead>
        <tr>
            <td><?php echo 'Liaison '.$Liaison->noliaison.' : '.$Liaison->nomportdepart.' - '.$Liaison->nomportarrivee?></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
        </tr>
        <?php
            $categorie_courante = "";
            foreach($lesTarifs as $row):
                if ($row->lettrecategorie==$categorie_courante)
                {
                    echo '';
                }
                else
                {
                    echo '';
                }
            endforeach ?>
    </tbody>
</table>

<?php 
foreach($lesPeriodes as $row ):
echo $row->noperiode.' - '.$row->datedebut.' - '.$row->datefin.'<br>';
endforeach ?>