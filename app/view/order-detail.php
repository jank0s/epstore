<!-- Page Content -->
<div class="container">
    <h1>Pregled naročila</h1>
    
    <div class="table-responsive full">
       <?php
        if(!empty($order)): ?>
            <h3>Podatki za dostavo</h3>
               
            <p><?= $order[0]['name'] . " " . $order[0]['surname']; ?> <br>
               <?= $order[0]['email'] ?> <br> 
               <?= $order[0]['phone']  ?> <br>
               <?= $order[0]['delivery_address'] ?> <br>
               <?= $order[0]['delivery_post'] . ", " . $order[0]['delivery_city'] ?> <br>
               <?= $order[0]['delivery_country'] ?></p> 

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
                    foreach ($order as $product): 
                        ?>
                <tr>            
                            <td><?= $product["item_quantity"] ?></td>
                            <td><?= $product['product_id'] ?></td>
                            <td><?= $product['product_name'] ?></td>
                            <td><?= $product['item_price'] ?></td>        
                        </tr>                
                <?php endforeach; ?>
            </tbody>
        </table>
        <p class="pull-right">Skupni znesek: <b><?= number_format($sum, 2) ?> EUR</b></p>
            <?php endif; ?>
    </div>

    <?php if (empty($order)): ?>
        <div class="text-center">
            <p>Naročilo ne obstaja</p>
        </div>
    <?php endif ?>
</div>