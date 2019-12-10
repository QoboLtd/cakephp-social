<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $posts
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __d('Qobo/Social', 'Actions') ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Post'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Accounts'), ['controller' => 'Accounts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Account'), ['controller' => 'Accounts', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Topics'), ['controller' => 'Topics', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Topic'), ['controller' => 'Topics', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="posts index large-9 medium-8 columns content">
    <h3><?= __d('Qobo/Social', 'Posts') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('account_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('external_post_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('post_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('url') ?></th>
                <th scope="col"><?= $this->Paginator->sort('subject') ?></th>
                <th scope="col"><?= $this->Paginator->sort('publish_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('trashed') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __d('Qobo/Social', 'Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $post): ?>
            <tr>
                <td><?= h($post->id) ?></td>
                <td><?= $post->has('account') ? $this->Html->link($post->account->handle, ['controller' => 'Accounts', 'action' => 'view', $post->account->id]) : '' ?></td>
                <td><?= h($post->external_post_id) ?></td>
                <td><?= h($post->post_id) ?></td>
                <td><?= h($post->type) ?></td>
                <td><?= h($post->url) ?></td>
                <td><?= h($post->subject) ?></td>
                <td><?= h($post->publish_date) ?></td>
                <td><?= h($post->trashed) ?></td>
                <td><?= h($post->created) ?></td>
                <td><?= h($post->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__d('Qobo/Social', 'View'), ['action' => 'view', $post->id]) ?>
                    <?= $this->Html->link(__d('Qobo/Social', 'Edit'), ['action' => 'edit', $post->id]) ?>
                    <?= $this->Form->postLink(__d('Qobo/Social', 'Delete'), ['action' => 'delete', $post->id], ['confirm' => __d('Qobo/Social', 'Are you sure you want to delete # {0}?', $post->id)]) ?>
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
