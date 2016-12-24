<!-- Page Content -->
<div class="container">
    <h1>Uporabniki</h1>
    <div class="row text-right">
            <a href="<?= BASE_URL . "users/add" ?>" class="btn btn-success">Dodaj uporabnika</a>
    </div>

    <br/>

    <div class="table-responsive full">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Ime</th>
                <th>Priimek</th>
                <th>Email</th>
                <th>Vloga</th>
                <th>Aktiviran</th>
                <th>Ustvarjen</th>
                <th>Spremeni status</th>
                <th>Urejanje</th>
            </tr>
            </thead>

            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['user_id'] ?></td>
                        <td><?= $user['name'] ?></td>
                        <td><?= $user['surname'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td><?= $user['role_name'] ?></td>
                        <td><?= $user['user_active']? 'DA' : 'NE' ?></td>
                        <td><?= $user['user_created_at'] ?></td>
                        <td><?php if($user['user_active']): ?>
                            <a href="<?= BASE_URL . "users/" . $user['user_id'] . "/deactivate" ?>" class="label label-warning">
                                <i class="fa fa-close" title="Deaktiviraj" aria-hidden="true"></i>
                            </a>
                            <?php else: ?>
                            <a href="<?= BASE_URL . "users/" . $user['user_id']  . "/activate" ?>" class="label label-success">
                                <i class="fa fa-check" title="aktiviraj" aria-hidden="true"></i>
                            </a>
                        <?php endif; ?>
                        </td> 
                        <td class="text-right table-links"> 
                            <a href="<?= BASE_URL . "users/" . $user['user_id'] . "/edit" ?>" class="label label-info">
                                <i class="fa fa-pencil" title="Uredi" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

    <?php if (empty($users)): ?>
        <div class="text-center">
            <p>Ni uporabnikov</p>
        </div>
    <?php endif ?>
</div>