<p>You are seeing this email because you have registered an account to <?= config('app.name') ?>. Click the link below to confirm your email email:</p>
<p><a href="<?= absolute_url('email/confirm?email=' . $email . '&token=' . $token) ?>"> <?= absolute_url('email/confirm?email=' . $email . '&token=' . $token) ?></a></p>
<p>If you did not registered an account, no further action is required.</p>