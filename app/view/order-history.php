<!-- Page Content -->
<div class="container">
    <h2>Oddano</h2>
    <div class="table-responsive full">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>ID naročila</th>
                <th>Oddano</th>
                <th>Zadnja sprememba</th>
                <th>Status naročila</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
                <?php foreach ($orders as $order):
                    if(($order['status_id']) == 1):
                    ?>
                <tr>
                        <td><?= $order['order_id'] ?></td>
                        <td><?= $order['order_created_at'] ?></td>
                        <td><?= $order['order_updated_at'] ?></td>
                        
                        <td><?php switch($order['status_id']){
                                    case(1):
                                        echo ("oddano");
                                        break;
                                    case(2):
                                        echo("potrjeno");
                                        break;
                                    case(3):
                                        echo("stornirano");
                                        break;
                                   }
                            ?></td>
                        <td><a href="<?= BASE_URL . "history/" . $order['order_id'] ?>">Podrobnosti</a></td>
            </tr> <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<h2>Potrjeno</h2>
    <div class="table-responsive full">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>ID naročila</th>
                <th>Oddano</th>
                <th>Zadnja sprememba</th>
                <th>Status naročila</th>
            </tr>
            </thead>

            <tbody>
                <?php foreach ($orders as $order):
                    if(($order['status_id']) == 2):
                    ?>
                   
                    <tr>
                        <td><?= $order['order_id'] ?></td>
                        <td><?= $order['order_created_at'] ?></td>
                        <td><?= $order['order_updated_at'] ?></td>
                        
                        <td><?php switch($order['status_id']){
                                    case(1):
                                        echo ("oddano");
                                        break;
                                    case(2):
                                        echo("potrjeno");
                                        break;
                                    case(3):
                                        echo("stornirano");
                                        break;
                                   }
                            ?></td>
                        <td><a href="<?= BASE_URL . "history/" . $order['order_id'] ?>">Podrobnosti</a></td>
                    </tr> <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <h2>Stornirano</h2>
    <div class="table-responsive full">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>ID naročila</th>
                <th>Oddano</th>
                <th>Zadnja sprememba</th>
                <th>Status naročila</th>
            </tr>
            </thead>

            <tbody>
                <?php foreach ($orders as $order):
                    if(($order['status_id']) == 3):
                    ?>
                   
                    <tr>
                        <td><?= $order['order_id'] ?></td>
                        <td><?= $order['order_created_at'] ?></td>
                        <td><?= $order['order_updated_at'] ?></td>
                        
                        <td><?php switch($order['status_id']){
                                    case(1):
                                        echo ("oddano");
                                        break;
                                    case(2):
                                        echo("potrjeno");
                                        break;
                                    case(3):
                                        echo("stornirano");
                                        break;
                                   }
                            ?></td>
                        <td><a href="<?= BASE_URL . "history/" . $order['order_id'] ?>">Podrobnosti</a></td>
                    </tr> <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?php if (empty($orders)): ?>
        <div class="text-center">
            <p>Ni naročil</p>
        </div>
    <?php endif ?>
</div>