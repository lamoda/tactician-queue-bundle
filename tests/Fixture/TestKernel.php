<?php

declare(strict_types=1);

namespace Lamoda\TacticianQueueBundle\Tests\Fixture;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use JMS\SerializerBundle\JMSSerializerBundle;
use Lamoda\QueueBundle\LamodaQueueBundle;
use Lamoda\TacticianQueueBundle\LamodaTacticianQueueBundle;
use League\Tactician\Bundle\TacticianBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

final class TestKernel extends Kernel
{
    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new DoctrineBundle(),
            new JMSSerializerBundle(),
            new TacticianBundle(),
            new LamodaQueueBundle(),
            new LamodaTacticianQueueBundle(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config.yml');
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheDir()
    {
        return $this->getProjectDir() . '/var/cache/' . $this->getEnvironment();
    }

    /**
     * {@inheritdoc}
     */
    public function getLogDir()
    {
        return $this->getProjectDir() . '/var/log';
    }
}
