<?php $this->layout('password/layout', [
    'page_title' => 'Reset password',
    'page_description' => 'Reset password page'
]) ?>

<?php $this->start('page_content') ?>

<h1 class="py-3 text-center">Reset password</h1>

<?php if (session_has('flash_messages')) { ?>

    <div class="alert alert-danger" role="alert">

        <?php
        $flash_messages = get_flash_messages('flash_messages');

        foreach ($flash_messages as $flash_message) {
            if (is_array($flash_message)) {
                foreach ($flash_message as $error_message) {
                    echo $error_message . '<br>';
                }
            } else {
                echo $flash_message . '<br>';
            }
        }
        ?>

    </div>

<?php } ?>

<div class="card shadow p-4">
    <form method="post" action="<?= absolute_url('/password/new') ?>">
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" id="email" name="email" class="form-control" value="<?= $email ?>">
        </div>

        <div class="form-group">
            <label for="password">New password</label>

            <div class="d-flex align-items-center">
                <input type="password" id="password" name="password" class="form-control">

                <span class="btn" id="password-toggler" title="Toggle display">
                    <i class="fa fa-eye-slash"></i>
                </span>
            </div>
        </div>

        <input type="submit" class="btn btn-primary w-100" value="Submit">
    </form>
</div>

<?php $this->stop() ?>