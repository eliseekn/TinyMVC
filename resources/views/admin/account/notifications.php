<?php $this->layout('layouts/admin', [
    'page_title' => __('notifications') . ' | Administration'
]) ?>

<?php $this->start('page_content') ?>

<div class="row mb-4">
    <div class="col-md-4 mb-md-0 mb-4">
        <div class="card card-metrics bg-light shadow-sm">
            <div class="card-body d-flex align-items-center justify-content-between">
                <p><i class="fa fa-bell fa-lg"></i> Total</p>
                <p class="font-weight-bold"><?= $notifications->getTotalItems() ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-metrics bg-light shadow-sm">
            <div class="card-body d-flex align-items-center justify-content-between">
                <p><i class="fa fa-eye-slash fa-lg"></i> <?= __('unread') ?></p>
                <p class="font-weight-bold"><?= $notifications_unread ?></p>
            </div>
        </div>
    </div>
</div>

<?php if (auth()->alerts && !empty($alerts)) : $this->insert('partials/alert', $alerts); endif ?>

<div class="card shadow-sm">
    <div class="card-header">
        <div class="d-flex flex-lg-row flex-column align-items-lg-center justify-content-lg-between">
            <span><?= __('notifications') ?></span>

            <div class="d-flex flex-lg-row flex-column mt-lg-0 mt-2">
                <span class="mr-md-3">
                    <input type="search" class="form-control" id="filter" placeholder="<?= __('search') ?>">
                </span>

                <span class="mt-lg-0 mt-2">
                    <create-notification action="<?= absolute_url('admin/account/notifications/create') ?>">
                        <button class="btn btn-outline-dark mr-2"><?= __('create') ?></button>
                    </create-notification>

                    <button class="btn btn-outline-dark mr-2" id="bulk-read" data-url="<?= absolute_url('admin/account/notifications/update') ?>">
                        <?= __('mark_all_as_read') ?>
                    </button>

                    <button class="btn btn-danger" id="bulk-delete" data-url="<?= absolute_url('admin/account/notifications/delete') ?>">
                        <?= __('bulk_delete') ?>
                    </button>
                </span>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th scope="col">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="select-all">
                                <label class="custom-control-label" for="select-all"></label>
                            </div>
                        </th>

                        <th scope="col"><i class="fa fa-sort"></i> ID</th>
                        <th scope="col"><i class="fa fa-sort"></i> <?= __('message') ?></th>
                        <th scope="col"><i class="fa fa-sort"></i> <?= __('created_at') ?></th>
                        <th scope="col"></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($notifications as $notification) : ?>
                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="<?= $notification->id ?>" data-id="<?= $notification->id ?>">
                                <label class="custom-control-label" for="<?= $notification->id ?>"></label>
                            </div>
                        </td>

                        <td><?= $notification->id ?></td>
                        <td><?= $notification->message ?></td>
                        <td><?= date_helper($notification->created_at)->time_elapsed() ?></td>

                        <td>
                            <update-item action="<?= absolute_url('admin/account/notifications/update', $notification->id) ?>" <?php if ($notification->status === 'read') : echo 'disabled="disabled"'; endif ?>>
                                <button type="submit" class="btn text-dark p-1" <?php if ($notification->status === 'unread') : echo 'title="' . __("mark_as_read") . '"'; endif ?>>
                                    <?php if ($notification->status === 'unread') : ?>
                                    <i class="fa fa-eye-slash"></i>
                                    <?php else : ?>
                                    <i class="fa fa-eye"></i>
                                    <?php endif ?>
                                </button>
                            </update-item>

                            <delete-item action="<?= absolute_url('admin/account/notifications/delete', $notification->id) ?>">
                                <a class="btn text-danger p-1" title="<?= __('delete') ?>">
                                    <i class="fa fa-trash-alt"></i>
                                </a>
                            </delete-item>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer d-flex align-items-center justify-content-between">
        <span><?= __('total_results') ?> <span class="font-weight-bold"><?= $notifications->getTotalItems() ?></span></span>
        <span><?= __('showing') ?> <span class="font-weight-bold"><?= $notifications->getPageTotalItems() === 0 ? $notifications->getFirstItem() : $notifications->getFirstItem() + 1 ?></span> <?= __('to') ?> <span class="font-weight-bold"><?= $notifications->getPageTotalItems() + $notifications->getFirstItem() ?></span></span>

        <?php $this->insert('partials/pagination', [
            'pagination' => $notifications
        ]) ?>
    </div>
</div>

<?php $this->stop() ?>