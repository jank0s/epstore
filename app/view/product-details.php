<div class="container-fluid">
    <div class="content-wrapper">	
		<div class="item-container">	
			<div class="container">	
                        <?php if(!empty($images)): ?>
                            <div class="col-md-12">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                       
                         <div class="carousel-inner" style="height:300px">
                            <?php $prvi = True; 
                            foreach($images as $img):
                                if($prvi): ?>
                            <div class="item active">
                                <img style=" height:300px; width:auto; display: block; margin-left: auto; margin-right: auto;" src="<?= IMAGES_URL . $img["image_name"] ?>" alt="">
                            </div>
                             <?php 
                             $prvi = False;
                             continue;
                             else:
                             ?>
                            <div class="item">
                                <img style=" height:300px; width:auto; display: block; margin-left: auto; margin-right: auto;" src="<?= IMAGES_URL . $img["image_name"] ?>" alt="">
                            </div>
                            <?php endif; 
                            endforeach; ?>
                        </div>
                        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                    </div>
                </div>
                            <?php endif; ?>
            </div>
					
				<div class="col-md-12">
					<div class="product-title"><?=($product['product_name']) ?></div>
					<div class="product-desc"><?=($product['product_description']) ?></div>
					<div class="product-rating">
                                        <?php for($i = 0; $i < intval($product['product_rating']); $i++): ?>
                                            <i class="fa fa-star gold"></i>                                        
                                        <?php
                                        endfor;
                                        for($i = 0 ; $i < 5 -intval($product['product_rating']); $i++): ?>
                                            <i class="fa fa-star-o"></i>
                                        <?php endfor; ?> <?= $product['product_rating'] ?> / 5</div>
                                        <hr>
                                        <div class="product-price"><?= ($product['product_price']) ?> €</div>
					<div class="product-stock">Na zalogi</div>
					<hr>
				            <?php if(SessionsController::customerAuthorized()): ?>
                                	<div class="btn-group cart">
                                
                                        <form action="add-to-cart" method="post" />
                                            <input name="product_id" value ="<?= $product['product_id'] ?>" type="hidden"/>
                                            <button type="submit" class="btn btn-success"/>
                                            Dodaj v košarico 
                                            </button>
                                        </form>
                                            <?= $form ?>
                                             
                                        </div>                                     
                                           <?php endif; ?>
                                        </div>
				</div>
			</div> 
		</div>
	