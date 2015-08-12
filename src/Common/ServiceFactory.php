<?php

namespace Mi\VideoManagerPro\SDK\Common;

use Mi\Guzzle\ServiceBuilder\ServiceFactoryInterface;
use Mi\VideoManagerPro\SDK\Common\Subscriber\AccessTokenAuthentication;
use Mi\VideoManagerPro\SDK\Common\Subscriber\ProcessErrorResponse;
use Mi\VideoManagerPro\SDK\Common\Subscriber\RefreshTokenAuthentication;
use Mi\VideoManagerPro\SDK\Common\Token\SecurityTokensInterface;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 */
class ServiceFactory implements ServiceFactoryInterface
{
    private $baseServiceFactory;
    private $securityTokens;

    /**
     * @param ServiceFactoryInterface $baseServiceFactory
     * @param SecurityTokensInterface $securityTokens
     */
    public function __construct(
        ServiceFactoryInterface $baseServiceFactory,
        SecurityTokensInterface $securityTokens
    ) {
        $this->baseServiceFactory = $baseServiceFactory;
        $this->securityTokens = $securityTokens;
    }

    /**
     * {@inheritdoc}
     */
    public function factory($config)
    {
        $service = $this->baseServiceFactory->factory($config);
        $service->getEmitter()->attach(new ProcessErrorResponse());
        $service->getEmitter()->attach(
            new AccessTokenAuthentication($service->getDescription(), $this->securityTokens->getAccessToken())
        );
        $service->getEmitter()->attach(
            new RefreshTokenAuthentication($service->getDescription(), $this->securityTokens->getRefreshToken())
        );

        return $service;
    }
}
