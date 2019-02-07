<?php
/**
 * @var \App\View\AppView $this
 * @var \Qobo\Social\Model\Entity\PostInteraction $interaction
 */
$label = $interaction->interaction_type->label ?? '';
if (empty($label)) {
 $label = $interaction->interaction_type->slug;
}

$valueType = $interaction->interaction_type->value_type;
$value = $interaction->get('value_' . $valueType);
?>
<div class="post-interaction">
    <span class="post-interaction-label"><?= $label ?></span>
    <span class="post-interaction-value"><?= $interaction->value_int ?></span>
</div>
