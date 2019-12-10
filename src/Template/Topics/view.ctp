<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $topic
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __d('Qobo/Social', 'Actions') ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'Edit Topic'), ['action' => 'edit', $topic->id]) ?> </li>
        <li><?= $this->Form->postLink(__d('Qobo/Social', 'Delete Topic'), ['action' => 'delete', $topic->id], ['confirm' => __d('Qobo/Social', 'Are you sure you want to delete # {0}?', $topic->id)]) ?> </li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Topics'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Topic'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Keywords'), ['controller' => 'Keywords', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Keyword'), ['controller' => 'Keywords', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Posts'), ['controller' => 'Posts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Post'), ['controller' => 'Posts', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="topics view large-9 medium-8 columns content">
    <h3><?= h($topic->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __d('Qobo/Social', 'Id') ?></th>
            <td><?= h($topic->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('Qobo/Social', 'Name') ?></th>
            <td><?= h($topic->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('Qobo/Social', 'Trashed') ?></th>
            <td><?= h($topic->trashed) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('Qobo/Social', 'Created') ?></th>
            <td><?= h($topic->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('Qobo/Social', 'Modified') ?></th>
            <td><?= h($topic->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('Qobo/Social', 'Active') ?></th>
            <td><?= $topic->active ? __d('Qobo/Social', 'Yes') : __d('Qobo/Social', 'No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __d('Qobo/Social', 'Description') ?></h4>
        <?= $this->Text->autoParagraph(h($topic->description)); ?>
    </div>
    <div class="related">
        <h4><?= __d('Qobo/Social', 'Related Posts') ?></h4>
        <?php if (!empty($topic->posts)): ?>
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
            <?php foreach ($topic->posts as $posts): ?>
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
    <div class="related">
        <h4><?= __d('Qobo/Social', 'Related Keywords') ?></h4>
        <?php if (!empty($topic->keywords)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __d('Qobo/Social', 'Id') ?></th>
                <th scope="col"><?= __d('Qobo/Social', 'Name') ?></th>
                <th scope="col"><?= __d('Qobo/Social', 'Type') ?></th>
                <th scope="col"><?= __d('Qobo/Social', 'Topic Id') ?></th>
                <th scope="col"><?= __d('Qobo/Social', 'Priority') ?></th>
                <th scope="col"><?= __d('Qobo/Social', 'Trashed') ?></th>
                <th scope="col"><?= __d('Qobo/Social', 'Created') ?></th>
                <th scope="col"><?= __d('Qobo/Social', 'Modified') ?></th>
                <th scope="col" class="actions"><?= __d('Qobo/Social', 'Actions') ?></th>
            </tr>
            <?php foreach ($topic->keywords as $keywords): ?>
            <tr>
                <td><?= h($keywords->id) ?></td>
                <td><?= h($keywords->name) ?></td>
                <td><?= h($keywords->type) ?></td>
                <td><?= h($keywords->topic_id) ?></td>
                <td><?= h($keywords->priority) ?></td>
                <td><?= h($keywords->trashed) ?></td>
                <td><?= h($keywords->created) ?></td>
                <td><?= h($keywords->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__d('Qobo/Social', 'View'), ['controller' => 'Keywords', 'action' => 'view', $keywords->id]) ?>
                    <?= $this->Html->link(__d('Qobo/Social', 'Edit'), ['controller' => 'Keywords', 'action' => 'edit', $keywords->id]) ?>
                    <?= $this->Form->postLink(__d('Qobo/Social', 'Delete'), ['controller' => 'Keywords', 'action' => 'delete', $keywords->id], ['confirm' => __d('Qobo/Social', 'Are you sure you want to delete # {0}?', $keywords->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
