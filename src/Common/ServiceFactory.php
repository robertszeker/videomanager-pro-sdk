<?php

namespace Mi\VideoManagerPro\SDK\Common;

use Mi\Guzzle\ServiceBuilder\ServiceFactoryInterface;
use Mi\VideoManagerPro\SDK\Common\Subscriber\AccessTokenAuthentication;
use Mi\VideoManagerPro\SDK\Common\Subscriber\RefreshTokenData;
use Mi\VideoManagerPro\SDK\Common\Token\OAuth2Interface;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 */
class ServiceFactory implements ServiceFactoryInterface
{
    private $baseServiceFactory;
    private $oAuth2Token;

    /**
     * @param ServiceFactoryInterface $baseServiceFactory
     * @param OAuth2Interface         $oAuth2Token
     */
    public function __construct(
        ServiceFactoryInterface $baseServiceFactory,
        OAuth2Interface $oAuth2Token
    ) {
        $this->baseServiceFactory = $baseServiceFactory;
        $this->oAuth2Token = $oAuth2Token;
    }

    /**
     * {@inheritdoc}
     */
    public function factory($config)
    {
        $service = $this->baseServiceFactory->factory($config);
        $service->getEmitter()->attach(
            new AccessTokenAuthentication($service->getDescription(), $this->oAuth2Token)
        );
        $service->getEmitter()->attach(
            new RefreshTokenData($service->getDescription(), $this->oAuth2Token)
        );

        return $service;
    }
}
