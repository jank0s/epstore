<!-- Page Content -->
<div class="container">
    <h1>Izdelki</h1>
    <div class="row text-right">
            <a href="<?= BASE_URL . "products/add" ?>" class="btn btn-success">Dodaj izdelek</a>
    </div>

    <br/>

    <div class="table-responsive full">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Ime</th>
                <th>Cena</th>
                <th>Opis</th>
                <th>Ocena</th>
                <th>Aktiviran</th>
                <th>Spremeni status</th>
                <th>Urejanje</th>
            </tr>
            </thead>

            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= $product['product_id'] ?></td>
                        <td><?= $product['product_name'] ?></td>
                        <td><?= $product['product_price'] ?></td>
                        <td><?= $product['product_description'] ?></td>
                        <td><?= $product['product_rating'] ?></td>
                        <td><?= $product['product_valid']? 'DA' : 'NE' ?></td> 
                        <td><?php if($product['product_valid']): ?>
                            <a href="<?= BASE_URL . "products/" . $product['product_id'] . "/deactivate" ?>" class="label label-warning">
                                <i class="fa fa-close" title="Deaktiviraj" aria-hidden="true"></i>
                            </a>
                            <?php else: ?>
                            <a href="<?= BASE_URL . "products/" . $product['product_id'] . "/activate" ?>" class="label label-success">
                                <i class="fa fa-check" title="aktiviraj" aria-hidden="true"></i>
                            </a>
                        <?php endif; ?>
                        </td> 
                           
                             <td class="text-right table-links"> 
                            <a href="<?= BASE_URL . "products/" . $product['product_id'] . "/edit" ?>" class="label label-info">
                                <i class="fa fa-pencil" title="Uredi" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

    <?php if (empty($products)): ?>
        <div class="text-center">
            <p>Ni izdelkov</p>
        </div>
    <?php endif ?>
</div>