<?php

namespace Mi\VideoManagerPro\SDK\Common\Subscriber;

use GuzzleHttp\Command\Event\PreparedEvent;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Event\SubscriberInterface;
use GuzzleHttp\Stream\Stream;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 */
class RefreshTokenData implements SubscriberInterface
{
    private $description;
    private $refreshToken;

    /**
     * @param Description    $description
     * @param string $refreshToken
     */
    public function __construct(Description $description, $refreshToken = null)
    {
        $this->description = $description;
        $this->refreshToken = $refreshToken;
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
        if ($this->refreshToken === null) {
            return;
        }

        $command   = $event->getCommand();
        $operation = $this->description->getOperation($command->getName());

        if ($operation->getData('refresh-token-data') === true) {
            $event->getRequest()->setBody(Stream::factory(json_encode(['refreshToken' => $this->refreshToken])));
        }
    }
}
