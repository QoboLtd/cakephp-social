<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $account
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __d('Qobo/Social', 'Actions') ?></li>
        <li><?= $this->Form->postLink(
                __d('Qobo/Social', 'Delete'),
                ['action' => 'delete', $account->id],
                ['confirm' => __d('Qobo/Social', 'Are you sure you want to delete # {0}?', $account->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Accounts'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Networks'), ['controller' => 'Networks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Network'), ['controller' => 'Networks', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Posts'), ['controller' => 'Posts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Post'), ['controller' => 'Posts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="accounts form large-9 medium-8 columns content">
    <?= $this->Form->create($account) ?>
    <fieldset>
        <legend><?= __d('Qobo/Social', 'Edit Account') ?></legend>
        <?php
            echo $this->Form->control('network_id', ['options' => $networks]);
            echo $this->Form->control('handle');
            echo $this->Form->control('active');
            echo $this->Form->control('is_ours');
            echo $this->Form->control('credentials');
            echo $this->Form->control('trashed', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__d('Qobo/Social', 'Submit')) ?>
    <?= $this->Form->end() ?>
</div>
