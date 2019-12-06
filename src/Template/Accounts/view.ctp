<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $account
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __d('Qobo/Social', 'Actions') ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'Edit Account'), ['action' => 'edit', $account->id]) ?> </li>
        <li><?= $this->Form->postLink(__d('Qobo/Social', 'Delete Account'), ['action' => 'delete', $account->id], ['confirm' => __d('Qobo/Social', 'Are you sure you want to delete # {0}?', $account->id)]) ?> </li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Accounts'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Account'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Networks'), ['controller' => 'Networks', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Network'), ['controller' => 'Networks', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Posts'), ['controller' => 'Posts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Post'), ['controller' => 'Posts', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="accounts view large-9 medium-8 columns content">
    <h3><?= h($account->handle) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __d('Qobo/Social', 'Id') ?></th>
            <td><?= h($account->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('Qobo/Social', 'Network') ?></th>
            <td><?= $account->has('network') ? $this->Html->link($account->network->name, ['controller' => 'Networks', 'action' => 'view', $account->network->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('Qobo/Social', 'Handle') ?></th>
            <td><?= h($account->handle) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('Qobo/Social', 'Trashed') ?></th>
            <td><?= h($account->trashed) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('Qobo/Social', 'Created') ?></th>
            <td><?= h($account->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('Qobo/Social', 'Modified') ?></th>
            <td><?= h($account->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('Qobo/Social', 'Active') ?></th>
            <td><?= $account->active ? __d('Qobo/Social', 'Yes') : __d('Qobo/Social', 'No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('Qobo/Social', 'Is Ours') ?></th>
            <td><?= $account->is_ours ? __d('Qobo/Social', 'Yes') : __d('Qobo/Social', 'No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __d('Qobo/Social', 'Credentials') ?></h4>
        <?= $this->Text->autoParagraph(h($account->credentials)); ?>
    </div>
    <div class="related">
        <h4><?= __d('Qobo/Social', 'Related Posts') ?></h4>
        <?php if (!empty($account->posts)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __d('Qobo/Social', 'Id') ?></th>
                <th scope="col"><?= __d('Qobo/Social', 'Account Id') ?></th>
                <th scope="col"><?= __d('Qobo/Social', 'Post Id') ?></th>
                <th scope="col"><?= __d('Qobo/Social', 'Type') ?></th>
                <th scope="col"><?= __d('Qobo/Social', 'Url') ?></th>
                <th scope="col"><?= __d('Qobo/Social', 'Subject') ?></th>
                <th scope="col"><?= __d('Qobo/Social', 'Content') ?></th>
                <th scope="col"><?= __d('Qobo/Social', 'Publish Date') ?></th>
                <th scope="col"><?= __d('Qobo/Social', 'Extra') ?></th>
                <th scope="col"><?= __d('Qobo/Social', 'Trashed') ?></th>
                <th scope="col"><?= __d('Qobo/Social', 'Created') ?></th>
                <th scope="col"><?= __d('Qobo/Social', 'Modified') ?></th>
                <th scope="col" class="actions"><?= __d('Qobo/Social', 'Actions') ?></th>
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
                    <?= $this->Html->link(__d('Qobo/Social', 'View'), ['controller' => 'Posts', 'action' => 'view', $posts->id]) ?>
                    <?= $this->Html->link(__d('Qobo/Social', 'Edit'), ['controller' => 'Posts', 'action' => 'edit', $posts->id]) ?>
                    <?= $this->Form->postLink(__d('Qobo/Social', 'Delete'), ['controller' => 'Posts', 'action' => 'delete', $posts->id], ['confirm' => __d('Qobo/Social', 'Are you sure you want to delete # {0}?', $posts->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
