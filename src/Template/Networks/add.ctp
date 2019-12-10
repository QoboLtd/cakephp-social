<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $network
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __d('Qobo/Social', 'Actions') ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Networks'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'List Accounts'), ['controller' => 'Accounts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__d('Qobo/Social', 'New Account'), ['controller' => 'Accounts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="networks form large-9 medium-8 columns content">
    <?= $this->Form->create($network) ?>
    <fieldset>
        <legend><?= __d('Qobo/Social', 'Add Network') ?></legend>
        <?php
            echo $this->Form->control('title');
            echo $this->Form->control('name');
            echo $this->Form->control('url');
            echo $this->Form->control('oauth_consumer_key');
            echo $this->Form->control('oauth_consumer_secret');
            echo $this->Form->control('active');
            echo $this->Form->control('trashed', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__d('Qobo/Social', 'Submit')) ?>
    <?= $this->Form->end() ?>
</div>
