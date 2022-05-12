<table border = 1>
    <thead>
        <tr>
            <th colspan="100%"><?php echo 'Liaison '.$Liaison->noliaison.' : '.$Liaison->nomportdepart.' - '.$Liaison->nomportarrivee?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td rowspan="2">Catégorie</td>
            <td rowspan="2">Type</td>
            <td colspan="100%">Période</td>
        </tr>
        <tr>
            <?php foreach($lesPeriodes as $unePeriode):
                $datedebut = date_create($unePeriode->datedebut);
                $datefin = date_create($unePeriode->datefin);
                echo '<td>'.$datedebut->format('d/m/Y').'<br>'.$datefin->format('d/m/Y').'</td>';
            endforeach ?>
        </tr>
        <?php
            $categorie_courante = "";
            foreach($lesCategoriesTypes as $uneCategorieType):
                        if ($uneCategorieType->lettrecategorie == $categorie_courante) //si même catégorie que ligne précédente
                        {
                            echo '<tr><td>'.$uneCategorieType->lettrecategorie.$uneCategorieType->notype.' - '.$uneCategorieType->libelletype.'</td>';
                            foreach($lesPeriodes as $unePeriode):
                                $tariftrouve = FALSE;
                                foreach($lesTarifs as $unTarif):
                                    if($unePeriode->noperiode == $unTarif->noperiode && $uneCategorieType->lettrecategorie == $unTarif->lettrecategorie && $uneCategorieType->notype == $unTarif->notype)
                                    {
                                        echo '<td>'.$unTarif->tarif.'</td>';
                                        $tariftrouve = TRUE;
                                    }
                                endforeach;
                                if(!$tariftrouve) { echo '<td>---</td>'; }        
                            endforeach;
                            echo '</tr>';
                        }
                        else //si catégorie différente de la ligne précédente
                        {
                            echo '<tr><td rowspan="'.$nombreDeLignes[$uneCategorieType->lettrecategorie].'">'.$uneCategorieType->lettrecategorie.'<br>'.$uneCategorieType->libellecategorie.'</td><td>'.$uneCategorieType->lettrecategorie.$uneCategorieType->notype.' - '.$uneCategorieType->libelletype.'</td>';
                            foreach($lesPeriodes as $unePeriode):
                                $tariftrouve = FALSE;
                                foreach($lesTarifs as $unTarif):
                                    if($unePeriode->noperiode == $unTarif->noperiode && $uneCategorieType->lettrecategorie == $unTarif->lettrecategorie && $uneCategorieType->notype == $unTarif->notype)
                                    {
                                        echo '<td>'.$unTarif->tarif.'</td>';
                                        $tariftrouve = TRUE;
                                    }
                                endforeach;
                                if(!$tariftrouve) { echo '<td>---</td>'; }        
                            endforeach;
                            echo '</tr>';
                            $categorie_courante = $uneCategorieType->lettrecategorie;
                        }
            endforeach ?>
    </tbody>
</table>
