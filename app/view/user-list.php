<!-- Page Content -->
<div class="container">
    <h1>Uporabniki</h1>
    <div class="row text-right">
            <a href="" class="btn btn-success">Dodaj uporabnika</a>
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
                <th></th>
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
                        <td class="text-right table-links">
                            <a href="" class="label label-info">
                                <i class="fa fa-pencil" title="Uredi" aria-hidden="true"></i>
                            </a>
                            <a href="" class="label label-danger">
                                <i class="fa fa-trash" title="Onemogoči" aria-hidden="true"></i>
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