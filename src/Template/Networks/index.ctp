<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $networks
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __d('Qobo/Social', 'Actions') ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Network'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Accounts'), ['controller' => 'Accounts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Account'), ['controller' => 'Accounts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="networks index large-9 medium-8 columns content">
    <h3><?= __d('Qobo/Social', 'Networks') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('url') ?></th>
                <th scope="col"><?= $this->Paginator->sort('active') ?></th>
                <th scope="col"><?= $this->Paginator->sort('trashed') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __d('Qobo/Social', 'Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($networks as $network): ?>
            <tr>
                <td><?= h($network->id) ?></td>
                <td><?= h($network->title) ?></td>
                <td><?= h($network->name) ?></td>
                <td><?= h($network->url) ?></td>
                <td><?= h($network->active) ?></td>
                <td><?= h($network->trashed) ?></td>
                <td><?= h($network->created) ?></td>
                <td><?= h($network->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__d('Qobo/Social', 'View'), ['action' => 'view', $network->id]) ?>
                    <?= $this->Html->link(__d('Qobo/Social', 'Edit'), ['action' => 'edit', $network->id]) ?>
                    <?= $this->Form->postLink(__d('Qobo/Social', 'Delete'), ['action' => 'delete', $network->id], ['confirm' => __d('Qobo/Social', 'Are you sure you want to delete # {0}?', $network->id)]) ?>
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
