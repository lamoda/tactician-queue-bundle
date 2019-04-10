<?php

declare(strict_types=1);

namespace Lamoda\TacticianQueueBundle\Tests;

use Lamoda\QueueBundle\Factory\PublisherFactory;
use Lamoda\QueueBundle\QueueInterface;
use Lamoda\TacticianQueueBundle\Tests\Fixture\OtherCommand;
use Lamoda\TacticianQueueBundle\Tests\Fixture\OtherHandler;
use Lamoda\TacticianQueueBundle\Tests\Fixture\TestCommand;
use Lamoda\TacticianQueueBundle\Tests\Fixture\TestHandler;
use League\Tactician\CommandBus;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class HandlingCommandViaQueueTest extends KernelTestCase
{
    /**
     * @var PublisherFactory | MockObject
     */
    private $publisherFactory;

    protected function setUp(): void
    {
        parent::setUp();

        static::bootKernel();

        $this->publisherFactory = $this->createMock(PublisherFactory::class);

        static::$kernel->getContainer()->set('lamoda_queue.factory.publisher', $this->publisherFactory);
    }

    public function testCommandShouldNoGoToTheQueue(): void
    {
        $command = new OtherCommand(1);

        $this->publisherFactory->expects($this->never())
            ->method('publish');

        $this->getCommandBus()->handle($command);

        $this->assertSame($command, $this->getOtherHandler()->getLastHandled());
    }

    public function testCommandShouldGoToTheQueue(): void
    {
        $command = new TestCommand(1);

        $this->publisherFactory->expects($this->once())
            ->method('publish')
            ->with($this->isInstanceOf(QueueInterface::class));

        $this->getCommandBus()->handle($command);

        $this->assertNull($this->getTestHandler()->getLastHandled());
    }

    private function getCommandBus(): CommandBus
    {
        return static::$kernel->getContainer()->get('test.tactician.commandbus');
    }

    private function getTestHandler(): TestHandler
    {
        return static::$kernel->getContainer()->get(TestHandler::class);
    }

    private function getOtherHandler(): OtherHandler
    {
        return static::$kernel->getContainer()->get(OtherHandler::class);
    }
}
