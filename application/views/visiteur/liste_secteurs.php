<div position: absolute;>
    <ul>
        <?php
            foreach($lesSecteurs as $unSecteur):
                echo '<li>'?> <a href="<?php echo site_url('visiteur/afficherTraversees/'.$unSecteur->nosecteur) ?>"> <?php echo $unSecteur->nomsecteur.'</a></li>' ;
            endforeach;
        ?>
    </ul>
</div>