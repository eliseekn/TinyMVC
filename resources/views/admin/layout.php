<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= absolute_url('/public/css/admin.css') ?>">
    <title><?= $page_title ?></title>
</head>

<body>

    <div class="d-flex" id="wrapper">
        <div class="bg-light border-light border-right min-vh-100" id="sidebar-wrapper">
            <div class="sidebar-title bg-dark text-light">
                <i class="fa fa-cog"></i> Administration
            </div>

            <div class="list-group list-group-flush">
                <a href="<?= absolute_url('/admin') ?>" class="list-group-item list-group-item-action bg-light">
                    <i class="fa fa-home"></i> Dashboard
                </a>
                <a href="<?= absolute_url('/admin/users') ?>" class="list-group-item list-group-item-action bg-light">
                    <i class="fa fa-dot-circle <?php if (is_current_page('users')) : echo 'text-primary'; endif ?>"></i> Users
                </a>
            </div>
        </div>

        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
                <button class="btn border-light text-light" id="sidebar-toggler" title="Toggle sidebar">
                    <i class="fa fa-bars"></i>
                </button>

                <div class="ml-auto">
                    <span class="text-white">Welcome, <em><?= explode(' ', get_user_session()->name)[0] ?></em>!</span>
                </div>

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="btn btn-danger" href="<?= absolute_url('/logout') ?>">Log out</a>
                    </li>
                </ul>
            </nav>

            <div class="container-fluid p-4">
                <?= $this->section('page_content') ?>
            </div>
        </div>
    </div>

    <script defer src="https://use.fontawesome.com/releases/v5.13.0/js/all.js"></script>
    <script defer src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script defer src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script defer src="<?= absolute_url('/public/js/index.js') ?>"></script>
    
</body>

</html>