<?php

namespace Mi\VideoManagerPro\SDK\Tests\Common;

use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Event\Emitter;
use Mi\Guzzle\ServiceBuilder\ServiceFactoryInterface;
use Mi\VideoManagerPro\SDK\Common\ServiceFactory;
use Mi\VideoManagerPro\SDK\Common\Subscriber\AccessTokenAuthentication;
use Mi\VideoManagerPro\SDK\Common\Subscriber\ProcessErrorResponse;
use Mi\VideoManagerPro\SDK\Common\Subscriber\RefreshTokenAuthentication;
use Mi\VideoManagerPro\SDK\Common\Token\SecurityTokensInterface;
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
        $securityTokens = $this->prophesize(SecurityTokensInterface::class);

        $serviceFactory = new ServiceFactory($baseFactory->reveal(), $securityTokens->reveal());
        $client         = $this->prophesize(GuzzleClient::class);
        $emitter        = $this->prophesize(Emitter::class);
        $description    = $this->prophesize(Description::class);

        $client->getEmitter()->willReturn($emitter->reveal());
        $client->getDescription()->willReturn($description->reveal());

        $emitter->attach(Argument::type(ProcessErrorResponse::class))->shouldBeCalled();
        $emitter->attach(Argument::type(AccessTokenAuthentication::class))->shouldBeCalled();
        $emitter->attach(Argument::type(RefreshTokenAuthentication::class))->shouldBeCalled();

        $baseFactory->factory(['class' => GuzzleClient::class, 'description' => []])->willReturn($client->reveal());

        $service = $serviceFactory->factory(['class' => GuzzleClient::class, 'description' => []]);

        self::assertInstanceOf(GuzzleClient::class, $service);
    }
}
