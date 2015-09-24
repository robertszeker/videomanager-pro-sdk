<?php

namespace Mi\VideoManagerPro\SDK\Common\Subscriber;

use GuzzleHttp\Command\Event\PreparedEvent;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Event\SubscriberInterface;
use GuzzleHttp\Query;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 */
class SetDuplicatedQueryParameterAggregator implements SubscriberInterface
{
    private $description;

    /**
     * @param Description $description
     */
    public function __construct(Description $description)
    {
        $this->description = $description;
    }

    /**
     * {@inheritdoc}
     */
    public function getEvents()
    {
        return ['prepared' => ['onPrepared', 'last']];
    }

    public function onPrepared(PreparedEvent $event)
    {
        $command = $event->getCommand();
        $operation = $this->description->getOperation($command->getName());

        if ($operation->getData('allow-duplicated-query-params') !== false) {
            $event->getRequest()->getQuery()->setAggregator(Query::duplicateAggregator());
        }
    }
}
