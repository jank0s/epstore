<div class="container">
    <h2 class="form-signin-heading">Urejanje slik</h2>
        <div class="col-md-2">
	<?php foreach($images as $img): ?>
            <div class="thumbnail">
                <a href="#" class="pull-right">izbriši sliko</a>
                <img style="width:200px;" src="<?= IMAGES_URL . $img["image_name"] ?>" alt="ni slike">
        </div>
        <?php endforeach; ?>
        </div>
    <div><?= $form ?></div>
</div>
