<div class="container-fluid">
    <div class="content-wrapper">	
		<div class="item-container">	
			<div class="container">	
				<div class="col-md-12">
                                    <!-- odkomentiraj za prikaz slik  -->
                                    <!--div class="product col-md-3 service-image-left">
                    
						<center>
							<img id="item-display" src="http://www.corsair.com/Media/catalog/product/g/s/gs600_psu_sideview_blue_2.png" alt=""></img>
						</center>
					</div>
					
					<div class="container service1-items col-sm-2 col-md-2 pull-left">
					
                                            <center>
							<a id="item-1" class="service1-item">
								<img src="http://www.corsair.com/Media/catalog/product/g/s/gs600_psu_sideview_blue_2.png" alt=""></img>
							</a>
							<a id="item-2" class="service1-item">
								<img src="http://www.corsair.com/Media/catalog/product/g/s/gs600_psu_sideview_blue_2.png" alt=""></img>
							</a>
							<a id="item-3" class="service1-item">
								<img src="http://www.corsair.com/Media/catalog/product/g/s/gs600_psu_sideview_blue_2.png" alt=""></img>
							</a>
						</center>
					</div-->
				</div>
					
				<div class="col-md-12">
					<div class="product-title"><?=($product['product_name']) ?></div>
					<div class="product-desc"><?=($product['product_description']) ?></div>
					<div class="product-rating"><i class="fa fa-star gold"></i> <i class="fa fa-star gold"></i> <i class="fa fa-star gold"></i> <i class="fa fa-star gold"></i> <i class="fa fa-star-o"></i> </div>
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
                                             </div>
                                           <?php endif; ?>
                                        </div>
				</div>
			</div> 
		</div>
		
	</div>
</div>

</div>