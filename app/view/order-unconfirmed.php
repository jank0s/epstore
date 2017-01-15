<!-- Page Content -->
<div class="container">
    <?php if (empty($orders)): ?>
        <div class="text-center">
            <p><h2>Ni naročil za pregled.</h2></p>
        </div>
    <?php else: ?>
    <h2>Neobdelano</h2>
    <div class="table-responsive full">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>ID naročila</th>
                <th>Oddano</th>
                <th>Zadnja sprememba</th>
                <th>Status naročila</th>
                <th></th>
                <th></th>
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
                        <td><a href="<?= BASE_URL . "orders/" . $order['order_id'] ?>">Podrobnosti</a></td>
                        <td><form action="<?= BASE_URL . "orders/activate" ?>" method="post">                        
                            <input type="hidden" name="order_id" value="<?= $order["order_id"] ?>" />
                            <button class="label label-success" title="Potrdi naročilo" aria-hidden="true"><i class="fa fa-check" title="Potrdi naročilo" aria-hidden="true"></i>
                            </button></form>
                        </td>
                        <td><form action="<?= BASE_URL . "orders/deactivate" ?>" method="post">                        
                            <input type="hidden" name="order_id" value="<?= $order["order_id"] ?>" />
                            <button class="label label-danger" title="Prekliči naročilo" aria-hidden="true"><i class="fa fa-close" title="Prekliči naročilo" aria-hidden="true"></i>
                            </button></form>
                        </td>
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
                <th></th>
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
                        <td><a href="<?= BASE_URL . "orders/" . $order['order_id'] ?>">Podrobnosti</a></td>
                        <td></td>
                        <td><form action="<?= BASE_URL . "orders/deactivate" ?>" method="post">                        
                            <input type="hidden" name="order_id" value="<?= $order["order_id"] ?>" />
                            <button class="label label-danger" title="Prekliči naročilo" aria-hidden="true"><i class="fa fa-close" title="Prekliči naročilo" aria-hidden="true"></i>
                            </button></form>
                        </td> 
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
                        <td><a href="<?= BASE_URL . "orders/" . $order['order_id'] ?>">Podrobnosti</a></td>
                    </tr> <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>