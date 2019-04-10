<?php

declare(strict_types=1);

namespace Lamoda\TacticianQueueBundle\Tests\Fixture;

final class OtherHandler
{
    /**
     * @var OtherCommand | null
     */
    private $lastHandled;

    public function handle(OtherCommand $command)
    {
        $this->lastHandled = $command;
    }

    public function getLastHandled(): ?OtherCommand
    {
        return $this->lastHandled;
    }
}
