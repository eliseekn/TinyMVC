<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?= __('login', true) ?>">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title><?= __('login', true) ?></title>
</head>

<body>
    <div class="d-flex align-items-center justify-content-center min-vh-100">
        <div class="container" style="width: 400px">
            <h1 class="py-3 text-center"><?= __('login', true) ?></h1>

            <?php 
            if (flash_messages()) :
                $this->insert('partials/alert', get_flash_messages());
            endif 
            ?>

            <?php 
            if(auth_attempts_exceeded()) : 
                $this->insert('partials/alert', [
                    'type' => 'danger',
                    'messages' => 'Authentication attempts exceeded. You must wait about ' . config('security.auth.unlock_timeout') . ' minute(s) before try again',
                    'display' => 'default',
                    'dismiss' => false
                ]);
            endif
            ?>

            <div class="card shadow p-4">
                <form method="post" action="<?= absolute_url('/authenticate') ?>">
                    <?= generate_csrf_token() ?>

                    <div class="form-group">
                        <label for="email"><?= __('email', true) ?></label>
                        <input type="email" id="email" name="email" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="password"><?= __('password', true) ?></label>

                        <div class="d-flex align-items-center">
                            <input type="password" id="password" name="password" class="form-control">

                            <span class="btn" id="password-toggler" title="Toggle display">
                                <i class="fa fa-eye-slash"></i>
                            </span>
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-lg-row justify-content-lg-between justify-content-center mb-3 mb-lg-0 mx-auto">
                        <div class="form-group custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                            <label class="custom-control-label" for="remember"><?= __('remember', true) ?></label>
                        </div>

                        <a href="<?= absolute_url('/password/forgot') ?>"><?= __('forgot_password', true) ?></a>
                    </div>

                    <?php if(auth_attempts_exceeded()) : ?>
                    <button type="submit" class="btn btn-block btn-primary loading" disabled><?= __('submit', true) ?></button>
                    <?php else : ?>
                    <button type="submit" class="btn btn-block btn-primary loading"><?= __('submit', true) ?></button>
                    <?php endif ?>
                </form>

                <p class="mt-4 text-center"><?= __('no_account', true) ?> <a href="<?= absolute_url('/signup') ?>"><?= __('signup_here', true) ?></a> </p>
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