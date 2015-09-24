<?php

namespace Mi\VideoManagerPro\SDK\tests\Common;

use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Event\Emitter;
use Mi\Guzzle\ServiceBuilder\ServiceFactoryInterface;
use Mi\VideoManagerPro\SDK\Common\ServiceFactory;
use Mi\VideoManagerPro\SDK\Common\Subscriber\AccessTokenAuthentication;
use Mi\VideoManagerPro\SDK\Common\Subscriber\RefreshTokenData;
use Mi\VideoManagerPro\SDK\Common\Token\OAuth2Interface;
use Prophecy\Argument;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 *
 * @covers Mi\VideoManagerPro\SDK\Common\ServiceFactory
 */
class ServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function factory()
    {
        $baseFactory = $this->prophesize(ServiceFactoryInterface::class);
        $oAuth2Token = $this->prophesize(OAuth2Interface::class);

        $serviceFactory = new ServiceFactory($baseFactory->reveal(), $oAuth2Token->reveal());
        $client = $this->prophesize(GuzzleClient::class);
        $emitter = $this->prophesize(Emitter::class);
        $description = $this->prophesize(Description::class);

        $client->getEmitter()->willReturn($emitter->reveal());
        $client->getDescription()->willReturn($description->reveal());

        $emitter->attach(Argument::type(AccessTokenAuthentication::class))->shouldBeCalled();
        $emitter->attach(Argument::type(RefreshTokenData::class))->shouldBeCalled();

        $factoryConfig = ['class' => GuzzleClient::class, 'description' => ['baseUrl' => '/base']];
        $baseFactory->factory($factoryConfig)->willReturn($client->reveal());

        $service = $serviceFactory->factory($factoryConfig);

        self::assertInstanceOf(GuzzleClient::class, $service);
    }
}
