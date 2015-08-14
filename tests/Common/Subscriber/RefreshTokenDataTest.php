<?php

namespace Mi\VideoManagerPro\SDK\Tests\Common\Subscriber;

use GuzzleHttp\Command\Command;
use GuzzleHttp\Command\Event\PreparedEvent;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\Operation;
use GuzzleHttp\Message\Request;
use GuzzleHttp\Query;
use GuzzleHttp\Stream\Stream;
use Mi\VideoManagerPro\SDK\Common\Subscriber\RefreshTokenData;
use Mi\VideoManagerPro\SDK\Common\Token\TokenInterface;
use Prophecy\Argument;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 * 
 * @covers Mi\VideoManagerPro\SDK\Common\Subscriber\RefreshTokenData
 */
class RefreshTokenDataTest extends \PHPUnit_Framework_TestCase
{
    private $command;
    private $description;
    private $operation;
    private $refreshToken;

    /**
     * @var RefreshTokenData
     */
    private $subscriber;

    /**
     * @test
     */
    public function processWithoutRefreshTokenData()
    {
        $event = $this->prophesize(PreparedEvent::class);

        $this->command->getName()->willReturn('command');
        $this->description->getOperation('command')->willReturn($this->operation->reveal());

        $this->operation->getData('refresh-token-data')->willReturn(null);

        $event->getCommand()->willReturn($this->command->reveal());

        $this->subscriber->onPrepared($event->reveal());
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

        $this->operation->getData('refresh-token-data')->willReturn(true);

        $request->setBody(Argument::type(Stream::class))->shouldBeCalled();

        $event->getRequest()->willReturn($request->reveal());
        $event->getCommand()->willReturn($this->command->reveal());

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
        $this->refreshToken = 'refresh';

        $this->subscriber = new RefreshTokenData($this->description->reveal(), $this->refreshToken);
    }
}
