<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $keyword
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Keyword'), ['action' => 'edit', $keyword->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Keyword'), ['action' => 'delete', $keyword->id], ['confirm' => __('Are you sure you want to delete # {0}?', $keyword->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Keywords'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Keyword'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Topics'), ['controller' => 'Topics', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Topic'), ['controller' => 'Topics', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="keywords view large-9 medium-8 columns content">
    <h3><?= h($keyword->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($keyword->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($keyword->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type') ?></th>
            <td><?= h($keyword->type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Topic') ?></th>
            <td><?= $keyword->has('topic') ? $this->Html->link($keyword->topic->name, ['controller' => 'Topics', 'action' => 'view', $keyword->topic->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Priority') ?></th>
            <td><?= h($keyword->priority) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Trashed') ?></th>
            <td><?= h($keyword->trashed) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($keyword->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($keyword->modified) ?></td>
        </tr>
    </table>
</div>
