<html>
    <div class="container">  
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicateurs -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active">
                    <img src="Atlantik.jpg" alt="Image1" style="width:100%;">
                </div>

                <div class="item">
                    <img src="chicago.jpg" alt="Image2" style="width:100%;">
                </div>
                
                <div class="item">
                    <img src="ny.jpg" alt="Image3" style="width:100%;">
                </div>
            </div>

            <!-- Boutons gauche et droite -->
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
    <?php echo img('Atlantik.jpg')?>
</html>