<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $network
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __d('Qobo/Social', 'Actions') ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'Edit Network'), ['action' => 'edit', $network->id]) ?> </li>
        <li><?= $this->Form->postLink(__d('Qobo/Social', 'Delete Network'), ['action' => 'delete', $network->id], ['confirm' => __d('Qobo/Social', 'Are you sure you want to delete # {0}?', $network->id)]) ?> </li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Networks'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Network'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Accounts'), ['controller' => 'Accounts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Account'), ['controller' => 'Accounts', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="networks view large-9 medium-8 columns content">
    <h3><?= h($network->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __d('Qobo/Social', 'Id') ?></th>
            <td><?= h($network->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('Qobo/Social', 'Title') ?></th>
            <td><?= h($network->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('Qobo/Social', 'Name') ?></th>
            <td><?= h($network->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('Qobo/Social', 'Url') ?></th>
            <td><?= h($network->url) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('Qobo/Social', 'Trashed') ?></th>
            <td><?= h($network->trashed) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('Qobo/Social', 'Created') ?></th>
            <td><?= h($network->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('Qobo/Social', 'Modified') ?></th>
            <td><?= h($network->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('Qobo/Social', 'Active') ?></th>
            <td><?= $network->active ? __d('Qobo/Social', 'Yes') : __d('Qobo/Social', 'No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __d('Qobo/Social', 'Oauth Consumer Key') ?></h4>
        <?= $this->Text->autoParagraph(h($network->oauth_consumer_key)); ?>
    </div>
    <div class="row">
        <h4><?= __d('Qobo/Social', 'Oauth Consumer Secret') ?></h4>
        <?= $this->Text->autoParagraph(h($network->oauth_consumer_secret)); ?>
    </div>
    <div class="related">
        <h4><?= __d('Qobo/Social', 'Related Accounts') ?></h4>
        <?php if (!empty($network->accounts)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __d('Qobo/Social', 'Id') ?></th>
                <th scope="col"><?= __d('Qobo/Social', 'Network Id') ?></th>
                <th scope="col"><?= __d('Qobo/Social', 'Handle') ?></th>
                <th scope="col"><?= __d('Qobo/Social', 'Active') ?></th>
                <th scope="col"><?= __d('Qobo/Social', 'Is Ours') ?></th>
                <th scope="col"><?= __d('Qobo/Social', 'Credentials') ?></th>
                <th scope="col"><?= __d('Qobo/Social', 'Trashed') ?></th>
                <th scope="col"><?= __d('Qobo/Social', 'Created') ?></th>
                <th scope="col"><?= __d('Qobo/Social', 'Modified') ?></th>
                <th scope="col" class="actions"><?= __d('Qobo/Social', 'Actions') ?></th>
            </tr>
            <?php foreach ($network->accounts as $accounts): ?>
            <tr>
                <td><?= h($accounts->id) ?></td>
                <td><?= h($accounts->network_id) ?></td>
                <td><?= h($accounts->handle) ?></td>
                <td><?= h($accounts->active) ?></td>
                <td><?= h($accounts->is_ours) ?></td>
                <td><?= h($accounts->credentials) ?></td>
                <td><?= h($accounts->trashed) ?></td>
                <td><?= h($accounts->created) ?></td>
                <td><?= h($accounts->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__d('Qobo/Social', 'View'), ['controller' => 'Accounts', 'action' => 'view', $accounts->id]) ?>
                    <?= $this->Html->link(__d('Qobo/Social', 'Edit'), ['controller' => 'Accounts', 'action' => 'edit', $accounts->id]) ?>
                    <?= $this->Form->postLink(__d('Qobo/Social', 'Delete'), ['controller' => 'Accounts', 'action' => 'delete', $accounts->id], ['confirm' => __d('Qobo/Social', 'Are you sure you want to delete # {0}?', $accounts->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
