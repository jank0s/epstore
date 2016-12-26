<!-- Page Content -->
<div class="container">
    <h1>Košarica</h1>
    
    <div class="table-responsive full">
       <?php
                if(!empty($cart)): ?>
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Količina</th>
                <th>ID</th>
                <th>Naziv izdelka</th>
                <th>Cena</th>
            </tr>
            </thead>

            <tbody>
                <?php
                    foreach ($cart as $product): ?>
                        <form action="<?= BASE_URL . "cart/update" ?>" method="post">
                            <input type="hidden" name="id" value="<?= $product["product_id"] ?>" />                    
                        <tr>
                            <td><input type="number" name="quantity" value="<?= $product["quantity"] ?>"/></td>
                            <td><?= $product['product_id'] ?></td>
                            <td><?= $product['product_name'] ?></td>
                            <td><?= $product['product_price'] ?></td>
                            <td><button class="fa fa-refresh" title="Posodobi" aria-hidden="true"></button></td>
                            </form>
                            <td><form action="<?= BASE_URL . "cart/remove" ?>" method="post">                        
                                <input type="hidden" name="id" value="<?= $product["product_id"] ?>" />
                                <button class="fa fa-close" title="Odstrani" aria-hidden="true"></button> </form>
                            </td>
                        </tr>                
                 
                <?php endforeach; ?>
            </tbody>
        </table>
        <p class="pull-right">Total: <b><?= number_format($total, 2) ?> EUR</b></p>
        <?php endif; ?>
    </div>

    <?php if (empty($cart)): ?>
        <div class="text-center">
            <p>Ni izdelkov v košarici</p>
        </div>
    <?php endif ?>
</div>