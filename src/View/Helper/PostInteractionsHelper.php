<?php
namespace Qobo\Social\View\Helper;

use Cake\View\Helper;
use Qobo\Social\Model\Entity\PostInteraction;

/**
 * PostInteractions helper
 */
class PostInteractionsHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'element' => 'Qobo/Social.interactions/default',
    ];

    /**
     * Takes the incoming post interaction(s) and returns a string of processed elements.
     *
     * @param \Qobo\Social\Model\Entity\PostInteraction|\Qobo\Social\Model\Entity\PostInteraction[] $interactions Interactions
     * @return string Output
     */
    public function render($interactions): string
    {
        $output = '';
        if (!is_array($interactions)) {
            $interactions = [$interactions];
        }

        foreach ($interactions as $interaction) {
            $output .= $this->renderElement($interaction);
        }

        return $output;
    }

    /**
     * Renders the element for a corresponding interaction.
     *
     * @param \Qobo\Social\Model\Entity\PostInteraction $interaction Interaction.
     * @return string Rendered element.
     */
    protected function renderElement(PostInteraction $interaction): string
    {
        if (empty($interaction->interaction_type)) {
            return '';
        }
        $element = $this->getConfig('element');

        return $this->_View->element($element, compact('interaction'));
    }
}
