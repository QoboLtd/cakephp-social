<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $keywords
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __d('Qobo/Social', 'Actions') ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Keyword'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Topics'), ['controller' => 'Topics', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Topic'), ['controller' => 'Topics', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="keywords index large-9 medium-8 columns content">
    <h3><?= __d('Qobo/Social', 'Keywords') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('topic_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('priority') ?></th>
                <th scope="col"><?= $this->Paginator->sort('trashed') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __d('Qobo/Social', 'Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($keywords as $keyword): ?>
            <tr>
                <td><?= h($keyword->id) ?></td>
                <td><?= h($keyword->name) ?></td>
                <td><?= h($keyword->type) ?></td>
                <td><?= $keyword->has('topic') ? $this->Html->link($keyword->topic->name, ['controller' => 'Topics', 'action' => 'view', $keyword->topic->id]) : '' ?></td>
                <td><?= h($keyword->priority) ?></td>
                <td><?= h($keyword->trashed) ?></td>
                <td><?= h($keyword->created) ?></td>
                <td><?= h($keyword->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__d('Qobo/Social', 'View'), ['action' => 'view', $keyword->id]) ?>
                    <?= $this->Html->link(__d('Qobo/Social', 'Edit'), ['action' => 'edit', $keyword->id]) ?>
                    <?= $this->Form->postLink(__d('Qobo/Social', 'Delete'), ['action' => 'delete', $keyword->id], ['confirm' => __d('Qobo/Social', 'Are you sure you want to delete # {0}?', $keyword->id)]) ?>
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
