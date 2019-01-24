<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $network
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Network'), ['action' => 'edit', $network->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Network'), ['action' => 'delete', $network->id], ['confirm' => __('Are you sure you want to delete # {0}?', $network->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Networks'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Network'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Accounts'), ['controller' => 'Accounts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Account'), ['controller' => 'Accounts', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="networks view large-9 medium-8 columns content">
    <h3><?= h($network->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($network->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($network->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($network->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Url') ?></th>
            <td><?= h($network->url) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Trashed') ?></th>
            <td><?= h($network->trashed) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($network->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($network->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Active') ?></th>
            <td><?= $network->active ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Oauth Consumer Key') ?></h4>
        <?= $this->Text->autoParagraph(h($network->oauth_consumer_key)); ?>
    </div>
    <div class="row">
        <h4><?= __('Oauth Consumer Secret') ?></h4>
        <?= $this->Text->autoParagraph(h($network->oauth_consumer_secret)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Accounts') ?></h4>
        <?php if (!empty($network->accounts)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Network Id') ?></th>
                <th scope="col"><?= __('Handle') ?></th>
                <th scope="col"><?= __('Active') ?></th>
                <th scope="col"><?= __('Is Ours') ?></th>
                <th scope="col"><?= __('Credentials') ?></th>
                <th scope="col"><?= __('Trashed') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
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
                    <?= $this->Html->link(__('View'), ['controller' => 'Accounts', 'action' => 'view', $accounts->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Accounts', 'action' => 'edit', $accounts->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Accounts', 'action' => 'delete', $accounts->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accounts->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
