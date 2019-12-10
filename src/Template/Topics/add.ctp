<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $topic
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __d('Qobo/Social', 'Actions') ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Topics'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Keywords'), ['controller' => 'Keywords', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Keyword'), ['controller' => 'Keywords', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Posts'), ['controller' => 'Posts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Post'), ['controller' => 'Posts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="topics form large-9 medium-8 columns content">
    <?= $this->Form->create($topic) ?>
    <fieldset>
        <legend><?= __d('Qobo/Social', 'Add Topic') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('description');
            echo $this->Form->control('active');
            echo $this->Form->control('trashed', ['empty' => true]);
            echo $this->Form->control('posts._ids', ['options' => $posts]);
        ?>
    </fieldset>
    <?= $this->Form->button(__d('Qobo/Social', 'Submit')) ?>
    <?= $this->Form->end() ?>
</div>
