<?php if ($display === 'default') : ?>

    <div class="alert alert-<?= $type ?> alert-dismissible show" role="alert">
        <?php if (!empty($title)) : ?>
        <h5 class="alert-heading"><?= $title ?></h5>
        <?php endif ?>

        <?= $message . '<br>' ?>

        <?php if ($dismiss === true) : ?>
        <button class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?php endif ?>
    </div>

<?php elseif ($display === 'popup') : ?>

    <alert-popup type="<?= $type ?>" message="<?= $message ?>" title="<?= $title ?>"></alert-popup>

<?php elseif ($display === 'toast') : ?>

    <alert-toast type="<?= $type ?>" message="<?= $message ?>" title="<?= $title ?>"></alert-toast>

<?php endif ?>
