<?php

namespace Mi\VideoManagerPro\SDK\Common\Subscriber;

use GuzzleHttp\Command\Event\PreparedEvent;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Event\SubscriberInterface;
use GuzzleHttp\Stream\Stream;
use Mi\VideoManagerPro\SDK\Common\Token\OAuth2Interface;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 */
class RefreshTokenData implements SubscriberInterface
{
    private $description;
    private $refreshToken;

    /**
     * @param Description     $description
     * @param OAuth2Interface $refreshToken
     */
    public function __construct(Description $description, OAuth2Interface $refreshToken)
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
        $command = $event->getCommand();
        $operation = $this->description->getOperation($command->getName());

        if ($operation->getData('refresh-token-data') === true) {
            $event->getRequest()->setBody(Stream::factory(json_encode(['refreshToken' => $this->refreshToken->getRefreshToken()])));
        }
    }
}
