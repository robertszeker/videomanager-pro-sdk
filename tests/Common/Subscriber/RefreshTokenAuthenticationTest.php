<?php

namespace Mi\VideoManagerPro\SDK\Tests\Common\Subscriber;

use GuzzleHttp\Command\Command;
use GuzzleHttp\Command\Event\PreparedEvent;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\Operation;
use GuzzleHttp\Message\Request;
use GuzzleHttp\Query;
use Mi\VideoManagerPro\SDK\Common\Subscriber\RefreshTokenAuthentication;
use Mi\VideoManagerPro\SDK\Common\Token\TokenInterface;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 * 
 * @covers Mi\VideoManagerPro\SDK\Common\Subscriber\RefreshTokenAuthentication
 */
class RefreshTokenAuthenticationTest extends \PHPUnit_Framework_TestCase
{
    private $command;
    private $description;
    private $operation;
    private $refreshToken;

    /**
     * @var RefreshTokenAuthentication
     */
    private $authentication;

    /**
     * @test
     */
    public function processWithoutRefreshTokenAuthentication()
    {
        $event = $this->prophesize(PreparedEvent::class);

        $this->command->getName()->willReturn('command');
        $this->description->getOperation('command')->willReturn($this->operation->reveal());

        $this->operation->getData('refresh-token-auth')->willReturn(null);

        $event->getCommand()->willReturn($this->command->reveal());

        $this->authentication->onPrepared($event->reveal());

    }

    /**
     * @test
     */
    public function process()
    {
        $event = $this->prophesize(PreparedEvent::class);
        $request = $this->prophesize(Request::class);
        $query = $this->prophesize(Query::class);

        $this->command->getName()->willReturn('command');

        $this->description->getOperation('command')->willReturn($this->operation->reveal());

        $this->operation->getData('refresh-token-auth')->willReturn(true);

        $request->getQuery()->willReturn($query->reveal());

        $event->getRequest()->willReturn($request->reveal());
        $event->getCommand()->willReturn($this->command->reveal());

        $this->refreshToken->getToken()->willReturn('token');

        $query->add('refreshToken', 'token')->shouldBeCalled();

        $this->authentication->onPrepared($event->reveal());

    }

    /**
     * @test
     */
    public function getEvents()
    {
        self::assertInternalType('array', $this->authentication->getEvents());
    }

    protected function setUp()
    {
        $this->command = $this->prophesize(Command::class);
        $this->description = $this->prophesize(Description::class);
        $this->operation = $this->prophesize(Operation::class);
        $this->refreshToken = $this->prophesize(TokenInterface::class);

        $this->authentication = new RefreshTokenAuthentication(
            $this->description->reveal(), $this->refreshToken->reveal()
        );
    }
}
