<div class="container">
    <h2 class="form-signin-heading">Urejanje slik</h2>
        <div class="col-md-6">
	<?php foreach($images as $img): ?>
            <div class="thumbnail">
                <form action="<?= BASE_URL . "products/" . $img['image_id'] ."/delete-image" ?>" method="post" class="pull-right">
                    <input type="hidden" name="image_id" value="<?= $img['image_id'] ?>" />
                    <button class="label label-danger" title="Zbriši sliko" aria-hidden="true"><i class="fa fa-trash-o" aria-hidden="true"></i>
                    </button></form>
                <img style="width:200px;" src="<?= IMAGES_URL . $img["image_name"] ?>" alt="ni slike"> 
        </div>
        <?php endforeach; ?>
        </div>
    <div class="col-md-6"><?= $form ?></div>
</div>
