<?php

namespace Mi\VideoManagerPro\SDK\Tests\Common\Subscriber;

use GuzzleHttp\Command\Command;
use GuzzleHttp\Command\Event\PreparedEvent;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\Operation;
use GuzzleHttp\Message\Request;
use GuzzleHttp\Query;
use Mi\VideoManagerPro\SDK\Common\Subscriber\SetDuplicatedQueryParameterAggregator;
use Prophecy\Argument;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 *
 * @covers Mi\VideoManagerPro\SDK\Common\Subscriber\SetDuplicatedQueryParameterAggregator
 */
class SetDuplicatedQueryParameterAggregatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SetDuplicatedQueryParameterAggregator
     */
    private $subscriber;
    private $command;
    private $description;
    private $operation;

    /**
     * @test
     */
    public function processWithAllowDuplicatedQueryParamsFalse()
    {
        $event = $this->prophesize(PreparedEvent::class);

        $this->command->getName()->willReturn('command');
        $this->description->getOperation('command')->willReturn($this->operation->reveal());

        $this->operation->getData('allow-duplicated-query-params')->willReturn(false);

        $event->getCommand()->willReturn($this->command->reveal());

        $this->subscriber->onPrepared($event->reveal());
    }

    /**
     * @test
     */
    public function processWithAllowDuplicatedQueryParamsF()
    {
        $event = $this->prophesize(PreparedEvent::class);
        $request = $this->prophesize(Request::class);
        $query = $this->prophesize(Query::class);

        $this->command->getName()->willReturn('command');

        $this->description->getOperation('command')->willReturn($this->operation->reveal());

        $this->operation->getData('allow-duplicated-query-params')->willReturn(true);

        $event->getRequest()->willReturn($request->reveal());
        $event->getCommand()->willReturn($this->command->reveal());

        $request->getQuery()->willReturn($query->reveal());

        $query->setAggregator(Argument::type('callable'))->shouldBeCalled();

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

        $this->subscriber = new SetDuplicatedQueryParameterAggregator($this->description->reveal());
    }
}
