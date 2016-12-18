<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Library</title>

<h1>All products</h1>

<ul>
    <?php foreach ($products as $product): ?>
        <li><?= $product["product_name"] ?> (<?= $product["product_description"] ?>) - <?= $product["product_price"] ?> EUR</li>
    <?php endforeach; ?>
</ul>
