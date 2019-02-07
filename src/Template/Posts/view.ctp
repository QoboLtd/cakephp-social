<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $post
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Post'), ['action' => 'edit', $post->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Post'), ['action' => 'delete', $post->id], ['confirm' => __('Are you sure you want to delete # {0}?', $post->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Posts'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Post'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Accounts'), ['controller' => 'Accounts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Account'), ['controller' => 'Accounts', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Posts'), ['controller' => 'Posts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Post'), ['controller' => 'Posts', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Topics'), ['controller' => 'Topics', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Topic'), ['controller' => 'Topics', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="posts view large-9 medium-8 columns content">
    <h3><?= h($post->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($post->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Account') ?></th>
            <td><?= $post->has('account') ? $this->Html->link($post->account->handle, ['controller' => 'Accounts', 'action' => 'view', $post->account->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('External Post Id') ?></th>
            <td><?= h($post->external_post_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Post Id') ?></th>
            <td><?= h($post->post_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type') ?></th>
            <td><?= h($post->type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Url') ?></th>
            <td><?= $this->Html->link($post->url, null, ['target' => '_blank']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Subject') ?></th>
            <td><?= h($post->subject) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Publish Date') ?></th>
            <td><?= h($post->publish_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Trashed') ?></th>
            <td><?= h($post->trashed) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($post->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($post->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Content') ?></h4>
        <?= $this->Text->autoParagraph(h($post->content)); ?>
    </div>
    <div class="row">
        <h4><?= __('Post Interactions') ?></h4>
        <?= $this->PostInteractions->parse($post->latest_post_interactions) ?>
    </div>
    <div class="related">
        <h4><?= __('Related Topics') ?></h4>
        <?php if (!empty($post->topics)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('Active') ?></th>
                <th scope="col"><?= __('Trashed') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($post->topics as $topics): ?>
            <tr>
                <td><?= h($topics->id) ?></td>
                <td><?= h($topics->name) ?></td>
                <td><?= h($topics->description) ?></td>
                <td><?= h($topics->active) ?></td>
                <td><?= h($topics->trashed) ?></td>
                <td><?= h($topics->created) ?></td>
                <td><?= h($topics->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Topics', 'action' => 'view', $topics->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Topics', 'action' => 'edit', $topics->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Topics', 'action' => 'delete', $topics->id], ['confirm' => __('Are you sure you want to delete # {0}?', $topics->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Posts') ?></h4>
        <?php if (!empty($post->posts)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Account Id') ?></th>
                <th scope="col"><?= __('External Post Id') ?></th>
                <th scope="col"><?= __('Post Id') ?></th>
                <th scope="col"><?= __('Type') ?></th>
                <th scope="col"><?= __('Url') ?></th>
                <th scope="col"><?= __('Subject') ?></th>
                <th scope="col"><?= __('Content') ?></th>
                <th scope="col"><?= __('Publish Date') ?></th>
                <th scope="col"><?= __('Extra') ?></th>
                <th scope="col"><?= __('Trashed') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($post->posts as $posts): ?>
            <tr>
                <td><?= h($posts->id) ?></td>
                <td><?= h($posts->account_id) ?></td>
                <td><?= h($posts->external_post_id) ?></td>
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
                    <?= $this->Html->link(__('View'), ['controller' => 'Posts', 'action' => 'view', $posts->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Posts', 'action' => 'edit', $posts->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Posts', 'action' => 'delete', $posts->id], ['confirm' => __('Are you sure you want to delete # {0}?', $posts->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
