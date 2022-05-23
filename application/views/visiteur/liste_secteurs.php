<div class="container bg-dark">
    <div class="row">
        <div class="col-sm-2">
            <?php
                foreach($lesSecteurs as $unSecteur):
                    ?> <a href="<?php echo site_url('visiteur/afficherHorairesTraversees/'.$unSecteur->nosecteur) ?>"> <?php echo $unSecteur->nomsecteur.'</a><br>' ;
                endforeach;
            ?>
        </div>
    </div>
</div>