<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $account
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Account'), ['action' => 'edit', $account->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Account'), ['action' => 'delete', $account->id], ['confirm' => __('Are you sure you want to delete # {0}?', $account->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Accounts'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Account'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Networks'), ['controller' => 'Networks', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Network'), ['controller' => 'Networks', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Posts'), ['controller' => 'Posts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Post'), ['controller' => 'Posts', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="accounts view large-9 medium-8 columns content">
    <h3><?= h($account->handle) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($account->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Network') ?></th>
            <td><?= $account->has('network') ? $this->Html->link($account->network->name, ['controller' => 'Networks', 'action' => 'view', $account->network->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Handle') ?></th>
            <td><?= h($account->handle) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Trashed') ?></th>
            <td><?= h($account->trashed) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($account->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($account->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Active') ?></th>
            <td><?= $account->active ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Ours') ?></th>
            <td><?= $account->is_ours ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Credentials') ?></h4>
        <?= $this->Text->autoParagraph(h($account->credentials)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Posts') ?></h4>
        <?php if (!empty($account->posts)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Account Id') ?></th>
                <th scope="col"><?= __('Post Id') ?></th>
                <th scope="col"><?= __('Type') ?></th>
                <th scope="col"><?= __('Url') ?></th>
                <th scope="col"><?= __('Subject') ?></th>
                <th scope="col"><?= __('Content') ?></th>
                <th scope="col"><?= __('Publish Date') ?></th>
                <th scope="col"><?= __('Extra') ?></th>
                <th scope="col"><?= __('Trashed') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($account->posts as $posts): ?>
            <tr>
                <td><?= h($posts->id) ?></td>
                <td><?= h($posts->account_id) ?></td>
                <td><?= h($posts->post_id) ?></td>
                <td><?= h($posts->type) ?></td>
                <td><?= h($posts->url) ?></td>
                <td><?= h($posts->subject) ?></td>
                <td><?= h($posts->content) ?></td>
                <td><?= h($posts->publish_date) ?></td>
                <td><?= h($posts->extra) ?></td>
                <td><?= h($posts->trashed) ?></td>
                <td><?= h($posts->created) ?></td>
                <td><?= h($posts->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Posts', 'action' => 'view', $posts->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Posts', 'action' => 'edit', $posts->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Posts', 'action' => 'delete', $posts->id], ['confirm' => __('Are you sure you want to delete # {0}?', $posts->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
