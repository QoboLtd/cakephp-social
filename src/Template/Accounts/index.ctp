<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $accounts
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __d('Qobo/Social', 'Actions') ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Account'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Networks'), ['controller' => 'Networks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Network'), ['controller' => 'Networks', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Posts'), ['controller' => 'Posts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Post'), ['controller' => 'Posts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="accounts index large-9 medium-8 columns content">
    <h3><?= __d('Qobo/Social', 'Accounts') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('network_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('handle') ?></th>
                <th scope="col"><?= $this->Paginator->sort('active') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_ours') ?></th>
                <th scope="col"><?= $this->Paginator->sort('trashed') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __d('Qobo/Social', 'Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($accounts as $account): ?>
            <tr>
                <td><?= h($account->id) ?></td>
                <td><?= $account->has('network') ? $this->Html->link($account->network->name, ['controller' => 'Networks', 'action' => 'view', $account->network->id]) : '' ?></td>
                <td><?= h($account->handle) ?></td>
                <td><?= h($account->active) ?></td>
                <td><?= h($account->is_ours) ?></td>
                <td><?= h($account->trashed) ?></td>
                <td><?= h($account->created) ?></td>
                <td><?= h($account->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__d('Qobo/Social', 'View'), ['action' => 'view', $account->id]) ?>
                    <?= $this->Html->link(__d('Qobo/Social', 'Edit'), ['action' => 'edit', $account->id]) ?>
                    <?= $this->Form->postLink(__d('Qobo/Social', 'Delete'), ['action' => 'delete', $account->id], ['confirm' => __d('Qobo/Social', 'Are you sure you want to delete # {0}?', $account->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __d('Qobo/Social', 'first')) ?>
            <?= $this->Paginator->prev('< ' . __d('Qobo/Social', 'previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__d('Qobo/Social', 'next') . ' >') ?>
            <?= $this->Paginator->last(__d('Qobo/Social', 'last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __d('Qobo/Social', 'Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
