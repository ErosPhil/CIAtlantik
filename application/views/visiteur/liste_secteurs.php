<div class="container-fluid bg-dark">
    <div class="row justify-content-center">
        <h5 style="color: white">Compagnie Atlantik</h5>
    </div>
</div>
<div class="row">
    <div class="col-lg-3">
        <div class="container bg-dark">
            <table class="table table-bordered">
                <tbody>
                <?php
                    foreach($lesSecteurs as $unSecteur):
                        echo "<tr><td>"?> <a href="<?php echo site_url('visiteur/afficherHorairesTraversees/'.$unSecteur->nosecteur) ?>"> <?php echo $unSecteur->nomsecteur.'</a></td></tr>' ;
                    endforeach;
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-9">
