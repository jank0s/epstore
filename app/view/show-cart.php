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
                    <tr>
                        <td><?= $product['quantity'] ?></td>
                        <td><?= $product['product_id'] ?></td>
                        <td><?= $product['product_name'] ?></td>
                        <td><?= $product['product_price'] ?></td>
                        
                    </tr>
                            <?php endforeach; 
                           ?>
            </tbody>
        </table>
        <?php
                endif;
                ?>
    </div>

    <?php if (empty($cart)): ?>
        <div class="text-center">
            <p>Ni izdelkov v košarici</p>
        </div>
    <?php endif ?>
</div>