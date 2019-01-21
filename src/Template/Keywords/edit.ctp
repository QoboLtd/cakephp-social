<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $keyword
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $keyword->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $keyword->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Keywords'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Topics'), ['controller' => 'Topics', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Topic'), ['controller' => 'Topics', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="keywords form large-9 medium-8 columns content">
    <?= $this->Form->create($keyword) ?>
    <fieldset>
        <legend><?= __('Edit Keyword') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('type');
            echo $this->Form->control('topic_id', ['options' => $topics]);
            echo $this->Form->control('priority');
            echo $this->Form->control('trashed', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
