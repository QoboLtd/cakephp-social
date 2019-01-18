<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $account
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $account->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $account->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Accounts'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Networks'), ['controller' => 'Networks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Network'), ['controller' => 'Networks', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Posts'), ['controller' => 'Posts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Post'), ['controller' => 'Posts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="accounts form large-9 medium-8 columns content">
    <?= $this->Form->create($account) ?>
    <fieldset>
        <legend><?= __('Edit Account') ?></legend>
        <?php
            echo $this->Form->control('network_id', ['options' => $networks]);
            echo $this->Form->control('handle');
            echo $this->Form->control('active');
            echo $this->Form->control('is_ours');
            echo $this->Form->control('credentials');
            echo $this->Form->control('trashed', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
