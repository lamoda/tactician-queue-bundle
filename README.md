Lamoda Tactician Queue Middleware
=================================

[![Build Status](https://travis-ci.org/lamoda/tactician-queue-bundle.svg?branch=master)](https://travis-ci.org/lamoda/tactician-queue-bundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/lamoda/tactician-queue-bundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/lamoda/tactician-queue-bundle/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/lamoda/tactician-queue-bundle/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/lamoda/tactician-queue-bundle/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/lamoda/tactician-queue-bundle/badges/build.png?b=master)](https://scrutinizer-ci.com/g/lamoda/tactician-queue-bundle/build-status/master)

Library provides middleware that gives you ability to execute commands via Tactician in async or delayed way

## Installation

### Composer

```sh
composer require lamoda/tactician-queue-bundle
```

## Configuration

Before usage, please read the documentation for [lamoda/queue-bundle](https://github.com/lamoda/queue-bundle)

Bundle provides special middleware for tactician integration. This middleware add supports
of async command execution, event with scheduling.

To enable this feature do the following:

1. Add extra configuration:
    ```yaml
    lamoda_tactician_queue:
        tactician_id: tactician.commandbus # Command bus service id
        command_serializer_id: lamoda_tactician_queue.default_command_serializer # Symfony serializer

    ```
2. Add at least one strategy, that will convert commands into jobs:
    ```yaml
    services:
        # ...
        several_domain_commands_strategy:
            class: Lamoda\TacticianQueue\Middleware\QueueProducerStrategy\CommandsListToCommandJobStrategy
            arguments:
                - async_command_queue
                - async_command_exchange
                - [ My\AsyncCommandInterface, My\SecondCommand ]
                - 15 # optional delay
            tags:
                - { name: tactician_queue.job_producing_strategy }
    ```
3. Add queue middleware to the list of tactician middlewares:
    ```yaml
    tactician:
        commandbus:
            default:
                middleware:
                    - tactician.middleware.locking
                    - lamoda_tactician_queue.middleware # Here it is
                    - tactician.middleware.command_handler
    ```
4. Now every time you call
    ```php
    <?php
    $commandBus->handle(new My\SecondCommand());
    ```
   this command will be published into the queue.
