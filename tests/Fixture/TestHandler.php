<?php

declare(strict_types=1);

namespace Lamoda\TacticianQueueBundle\Tests\Fixture;

final class TestHandler
{
    /**
     * @var TestCommand | null
     */
    private $lastHandled;

    public function handle(TestCommand $command)
    {
        $this->lastHandled = $command;
    }

    /**
     * @return TestCommand|null
     */
    public function getLastHandled(): ?TestCommand
    {
        return $this->lastHandled;
    }
}
