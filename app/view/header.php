<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="EP - spletna trgovina">
    <meta name="author" content="EP">

    <title>EPStore - spletna trgovina</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "bootstrap.min.css" ?>">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "font-awesome.min.css" ?>">

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src=<?= JS_URL . "html5shiv.js" ?> ></script>
    <script src =<?= JS_URL . "respond.min.js" ?> ></script>
    <![endif]-->

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= BASE_URL ?>">EPStore <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php if (SessionsController::adminAuthorized() || SessionsController::merchantAuthorized()): ?>
                    <li>
                        <a href="<?= BASE_URL . "users" ?>">Uporabniki</a>
                    </li>
                <?php endif ?>
                <?php if (SessionsController::merchantAuthorized()): ?>
                    <li>
                        <a href="#">Naročila</a>
                    </li>
                    <li>
                        <a href="#">Izdelki</a>
                    </li>
                <?php endif ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if (SessionsController::loggedIn()): ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <b><i class="fa fa-user-circle-o" aria-hidden="true"></i> <?= $_SESSION['user']['name'] . ' ' . $_SESSION['user']['surname'] ?></b>
                            <span class="caret"></span>
                        </a>
                        <ul id="login-dp" class="dropdown-menu">
                            <li>
                                <a href="<?= BASE_URL . "users/" . $_SESSION['user']['user_id'] . "/edit" ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Profil</a>
                            </li>
                            <li>
                                <a href="<?= BASE_URL . "logout" ?>"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Odjava</a>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="<?= BASE_URL . "register" ?>">Registracija</a>
                    </li>
                    <li>
                        <a href="<?= BASE_URL . "login" ?>">Prijava</a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
