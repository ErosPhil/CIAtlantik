<html>
    <div class="col-sm">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>

            <div class="carousel-inner">
                <div class="carousel-item active">
                    <?php echo img('Groix.jpg','Image1','100%','800'); ?>
                    <div class="carousel-caption d-none d-md-block">
                        <h5 style="color: white">Île de Groix</h5>
                        <p style="color: white">Morbihan</p>
                    </div>
                </div>

                <div class="carousel-item">
                    <?php echo img('Baie_Quiberon.jpg','Image2','100%','800'); ?>
                    <div class="carousel-caption d-none d-md-block">
                        <h5 style="color: black">Baie de Quiberon</h5>
                        <p style="color: black">Morbihan</p>
                    </div>
                </div>
                
                <div class="carousel-item">
                    <?php echo img('sauzon_1.jpg','Image3','100%','800'); ?>
                    <div class="carousel-caption d-none d-md-block">
                        <h5 style="color: white">Sauzon</h5>
                        <p style="color: white">Morbihan</p>
                    </div>
                </div>
            </div>

            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Précédent</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Suivant</span>
            </a>
        </div>
    </div>
</html>