<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $keyword
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __d('Qobo/Social', 'Actions') ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Keywords'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Topics'), ['controller' => 'Topics', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Topic'), ['controller' => 'Topics', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="keywords form large-9 medium-8 columns content">
    <?= $this->Form->create($keyword) ?>
    <fieldset>
        <legend><?= __d('Qobo/Social', 'Add Keyword') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('type');
            echo $this->Form->control('topic_id', ['options' => $topics]);
            echo $this->Form->control('priority');
            echo $this->Form->control('trashed', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__d('Qobo/Social', 'Submit')) ?>
    <?= $this->Form->end() ?>
</div>
