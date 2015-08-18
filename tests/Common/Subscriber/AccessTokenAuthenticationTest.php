<?php

namespace Mi\VideoManagerPro\SDK\Tests\Common\Subscriber;

use GuzzleHttp\Command\Command;
use GuzzleHttp\Command\Event\PreparedEvent;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\Operation;
use GuzzleHttp\Message\Request;
use GuzzleHttp\Query;
use Mi\VideoManagerPro\SDK\Common\Subscriber\AccessTokenAuthentication;
use Mi\VideoManagerPro\SDK\Common\Token\OAuth2Interface;
use Mi\VideoManagerPro\SDK\Common\Token\TokenInterface;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 * 
 * @covers Mi\VideoManagerPro\SDK\Common\Subscriber\AccessTokenAuthentication
 */
class AccessTokenAuthenticationTest extends \PHPUnit_Framework_TestCase
{
    private $command;
    private $description;
    private $operation;
    private $accessToken;

    /**
     * @var AccessTokenAuthentication
     */
    private $subscriber;

    /**
     * @test
     */
    public function processWithAccessTokenAuthFalse()
    {
        $event = $this->prophesize(PreparedEvent::class);

        $this->command->getName()->willReturn('command');
        $this->description->getOperation('command')->willReturn($this->operation->reveal());

        $this->operation->getData('access-token-auth')->willReturn(false);

        $event->getCommand()->willReturn($this->command->reveal());

        $this->subscriber->onPrepared($event->reveal());
    }

    /**
     * @test
     */
    public function processWithoutAccessTokenAuthentication()
    {
        $event = $this->prophesize(PreparedEvent::class);
        $request = $this->prophesize(Request::class);

        $this->command->getName()->willReturn('command');

        $this->description->getOperation('command')->willReturn($this->operation->reveal());

        $this->operation->getData('access-token-auth')->willReturn(null);

        $event->getRequest()->willReturn($request->reveal());
        $event->getCommand()->willReturn($this->command->reveal());

        $request->addHeader('Bearer', 'access')->shouldBeCalled();

        $this->subscriber->onPrepared($event->reveal());
    }

    /**
     * @test
     */
    public function getEvents()
    {
        self::assertInternalType('array', $this->subscriber->getEvents());
    }

    protected function setUp()
    {
        $this->command = $this->prophesize(Command::class);
        $this->description = $this->prophesize(Description::class);
        $this->operation = $this->prophesize(Operation::class);
        $this->accessToken = $this->prophesize(OAuth2Interface::class);
        $this->accessToken->getAccessToken()->willReturn('access');

        $this->subscriber = new AccessTokenAuthentication($this->description->reveal(), $this->accessToken->reveal());
    }
}
