<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $post
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __d('Qobo/Social', 'Actions') ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Posts'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Accounts'), ['controller' => 'Accounts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Account'), ['controller' => 'Accounts', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Posts'), ['controller' => 'Posts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Post'), ['controller' => 'Posts', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Topics'), ['controller' => 'Topics', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Topic'), ['controller' => 'Topics', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="posts form large-9 medium-8 columns content">
    <?= $this->Form->create($post) ?>
    <fieldset>
        <legend><?= __d('Qobo/Social', 'Add Post') ?></legend>
        <?php
            echo $this->Form->control('account_id', ['options' => $accounts]);
            echo $this->Form->control('post_id');
            echo $this->Form->control('type');
            echo $this->Form->control('url');
            echo $this->Form->control('subject');
            echo $this->Form->control('content');
            echo $this->Form->control('publish_date', ['empty' => true]);
            echo $this->Form->control('extra');
            echo $this->Form->control('trashed', ['empty' => true]);
            echo $this->Form->control('topics._ids', ['options' => $topics]);
        ?>
    </fieldset>
    <?= $this->Form->button(__d('Qobo/Social', 'Submit')) ?>
    <?= $this->Form->end() ?>
</div>
