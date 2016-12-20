<!-- Page Content -->
<div class="container">

    <div class="row">

        <div class="col-md-3">
            <p class="lead">Izdelki</p>
            <div class="list-group">
                <a href="#" class="list-group-item">Kategorija 1</a>
                <a href="#" class="list-group-item">Kategorija 2</a>
                <a href="#" class="list-group-item">Kategorija 3</a>
            </div>
        </div>

        <div class="col-md-9">

            <div class="row carousel-holder">

                <div class="col-md-12">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="item active">
                                <img class="slide-image" src="<?= IMAGES_URL . "800x300.png" ?>" alt="">
                            </div>
                            <div class="item">
                                <img class="slide-image" src="<?= IMAGES_URL . "800x300.png" ?>" alt="">
                            </div>
                            <div class="item">
                                <img class="slide-image" src="<?= IMAGES_URL . "800x300.png" ?>" alt="">
                            </div>
                        </div>
                        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                    </div>
                </div>

            </div>

            <div class="row">
                <?php foreach ($products as $product): ?>
                    <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <img src="<?= IMAGES_URL . "320x150.png" ?>" alt="">
                            <div class="caption">
                                <h4>
                                    <a href="#"><?= $product['product_name'] ?></a>
                                </h4>
                                <h4 class="pull-right"><?= $product['product_price'] ?> EUR</h4>
                                </br>
                                <p><?= $product['product_description'] ?></p>
                            </div>
                            <div class="ratings">
                                <p class="pull-right">15 ocen</p>
                                <p>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>

    </div>

</div>


