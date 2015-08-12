<?php

namespace Mi\VideoManagerPro\SDK\Common\Subscriber;

use GuzzleHttp\Command\Event\PreparedEvent;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Event\SubscriberInterface;
use Mi\VideoManagerPro\SDK\Common\Token\TokenInterface;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 */
class RefreshTokenAuthentication implements SubscriberInterface
{
    private $description;
    private $refreshToken;

    /**
     * @param Description    $description
     * @param TokenInterface $refreshToken
     */
    public function __construct(Description $description, TokenInterface $refreshToken = null)
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

        if ($operation->getData('refresh-token-auth') === true) {
            $query = $event->getRequest()->getQuery();
            $query->add('refreshToken', $this->refreshToken->getToken());
        }
    }
}
