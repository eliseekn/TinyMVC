<p>You are seeing this email because you have requested connexion to your account on <?= config('app.name') ?>. Click the link below to process log in:</p>
<p><a href="<?= absolute_url('email/auth?email=' . $email . '&token=' . $token) ?>"> <?= absolute_url('email/auth?email=' . $email . '&token=' . $token) ?></a></p>
<p>If you did not registered an account, no further action is required.</p>