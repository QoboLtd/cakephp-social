<?php
namespace Qobo\Social\Provider;

use Qobo\Social\Model\Entity\Topic;

/**
 * Topic Interface
 */
interface TopicProviderInterface
{
    /**
     * Topic entity setter.
     *
     * @param \Qobo\Social\Model\Entity\Topic $topic Topic entity.
     * @return void
     */
    public function setTopic(Topic $topic): void;

    /**
     * Topic entity getter.
     *
     * @return \Qobo\Social\Model\Entity\Topic $topic Topic entity.
     */
    public function getTopic(): Topic;
}
