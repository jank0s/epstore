<!-- Page Content -->
<div class="container">

    <div class="row">

        <div class="col-md-3">
            <div class="list-group">
                <?= $form ?>
            </div>
        </div>

        <div class="col-md-9">

            <div class="row carousel-holder">
                <!--Odkomentiraj za slide div -->
                <!--div class="col-md-12">
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
                </div-->

            </div>

            <div class="row">
                <?php foreach ($products as $product): ?>
                    <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <?php
                            $image = ImageDB::get(["product_id" => $product["product_id"]]);
                                if(count($image) > 0):
                                ?>
                            <img class="product-list" src="<?= IMAGES_URL . $image[0]['image_name'] ?>" alt="">
                            <?php else: ?>
                                  <img class="product-list" src="<?= IMAGES_URL . '320x150.png' ?>" alt="">
                            <?php endif; ?>
                            <div class="caption">
                                <h4>
                                    <a href="<?= BASE_URL . 'products/' . $product['product_id'] ?>"><?= $product['product_name'] ?></a>
                                </h4>
                                <h4 class="pull-right"><?= $product['product_price'] ?> €</h4>
                                <p class="pull-left"><?= $product['product_description'] ?></p>
                            </div>
                            <div class="ratings">
                                <p class="pull-right">
                        <?=
                                $ratingCount = ProductDB::getProductRating($product);
                                switch($ratingCount){
                                    case(1):
                                        echo " ocena";
                                        break;
                                    case(2):
                                        echo " oceni";
                                        break;
                                    default:
                                        echo " ocen";
                                        break;
                                    }      
                        ?>
                                </p>
                                <p>
                                    <?php for($i = 0; $i < intval($product['product_rating']); $i++): ?>
                                        <span class="glyphicon glyphicon-star"></span>
                                    <?php endfor; ?>
                                    <?php for($i = 0 ; $i < 5 -intval($product['product_rating']); $i++): ?>
                                        <span class="glyphicon glyphicon-star-empty"></span>
                                    <?php endfor; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>

    </div>

</div>


