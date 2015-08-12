<?php

namespace Mi\VideoManagerPro\SDK\Common\Subscriber;

use GuzzleHttp\Command\Event\PreparedEvent;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Event\SubscriberInterface;
use Mi\VideoManagerPro\SDK\Common\Token\TokenInterface;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 */
class AccessTokenAuthentication implements SubscriberInterface
{
    private $description;
    private $accessToken;

    /**
     * @param Description    $description
     * @param TokenInterface $accessToken
     */
    public function __construct(Description $description, TokenInterface $accessToken = null)
    {
        $this->description = $description;
        $this->accessToken = $accessToken;
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
        if ($this->accessToken === null) {
            return;
        }

        $command   = $event->getCommand();
        $operation = $this->description->getOperation($command->getName());

        if ($operation->getData('access-token-auth') !== false) {
            $event->getRequest()->addHeader('Bearer', $this->accessToken->getToken());
        }
    }
}
