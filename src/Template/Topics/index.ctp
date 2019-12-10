<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $topics
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __d('Qobo/Social', 'Actions') ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Topic'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Keywords'), ['controller' => 'Keywords', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Keyword'), ['controller' => 'Keywords', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Posts'), ['controller' => 'Posts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Post'), ['controller' => 'Posts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="topics index large-9 medium-8 columns content">
    <h3><?= __d('Qobo/Social', 'Topics') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('active') ?></th>
                <th scope="col"><?= $this->Paginator->sort('trashed') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __d('Qobo/Social', 'Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($topics as $topic): ?>
            <tr>
                <td><?= h($topic->id) ?></td>
                <td><?= h($topic->name) ?></td>
                <td><?= h($topic->active) ?></td>
                <td><?= h($topic->trashed) ?></td>
                <td><?= h($topic->created) ?></td>
                <td><?= h($topic->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__d('Qobo/Social', 'View'), ['action' => 'view', $topic->id]) ?>
                    <?= $this->Html->link(__d('Qobo/Social', 'Edit'), ['action' => 'edit', $topic->id]) ?>
                    <?= $this->Form->postLink(__d('Qobo/Social', 'Delete'), ['action' => 'delete', $topic->id], ['confirm' => __d('Qobo/Social', 'Are you sure you want to delete # {0}?', $topic->id)]) ?>
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
