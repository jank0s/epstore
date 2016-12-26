<!-- Page Content -->
<div class="container">
    <h1>Predračun</h1>
    
    <div class="table-responsive full">
       <?php
        if(!empty($cart)): ?>
            <h3>Podatki za dostavo</h3>
               
            <p><?= $user['name'] . " " . $user['surname']; ?> <br>
               <?= $user['email'] ?> <br> 
               <?= $user['phone']  ?> <br>
               <?= $user['user_address'] ?> <br>
               <?= $user['user_post'] . ", " . $user['user_city'] ?> <br>
               <?= $user['user_country'] ?></p> 

            <h3>Podatki o izdelkih</h3>
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Količina</th>
                <th>ID</th>
                <th>Naziv izdelka</th>
                <th>Cena (EUR)</th>
            </tr>
            </thead>

            <tbody>
                <?php
                    foreach ($cart as $product): ?>
                        <tr>            
                            <input type="hidden" name="id" value="<?= $product["product_id"] ?>" />                    
                            <td><?= $product["quantity"] ?></td>
                            <td><?= $product['product_id'] ?></td>
                            <td><?= $product['product_name'] ?></td>
                            <td><?= $product['product_price'] ?></td>        
                        </tr>                
                <?php endforeach; ?>
            </tbody>
        </table>
        <p class="pull-right">Skupni znesek: <b><?= number_format($total, 2) ?> EUR</b></p>
            <a href="<?= BASE_URL . "cart/create-invoice" ?>" class="btn btn-success pull-left">Oddaj naročilo</a>
            <?php endif; ?>
    </div>

    <?php if (empty($cart)): ?>
        <div class="text-center">
            <p>Ni izdelkov v košarici</p>
        </div>
    <?php endif ?>
</div>