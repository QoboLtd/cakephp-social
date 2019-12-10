<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $keyword
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __d('Qobo/Social', 'Actions') ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'Edit Keyword'), ['action' => 'edit', $keyword->id]) ?> </li>
        <li><?= $this->Form->postLink(__d('Qobo/Social', 'Delete Keyword'), ['action' => 'delete', $keyword->id], ['confirm' => __d('Qobo/Social', 'Are you sure you want to delete # {0}?', $keyword->id)]) ?> </li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Keywords'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Keyword'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Topics'), ['controller' => 'Topics', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Topic'), ['controller' => 'Topics', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="keywords view large-9 medium-8 columns content">
    <h3><?= h($keyword->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __d('Qobo/Social', 'Id') ?></th>
            <td><?= h($keyword->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('Qobo/Social', 'Name') ?></th>
            <td><?= h($keyword->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('Qobo/Social', 'Type') ?></th>
            <td><?= h($keyword->type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('Qobo/Social', 'Topic') ?></th>
            <td><?= $keyword->has('topic') ? $this->Html->link($keyword->topic->name, ['controller' => 'Topics', 'action' => 'view', $keyword->topic->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('Qobo/Social', 'Priority') ?></th>
            <td><?= h($keyword->priority) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('Qobo/Social', 'Trashed') ?></th>
            <td><?= h($keyword->trashed) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('Qobo/Social', 'Created') ?></th>
            <td><?= h($keyword->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('Qobo/Social', 'Modified') ?></th>
            <td><?= h($keyword->modified) ?></td>
        </tr>
    </table>
</div>
