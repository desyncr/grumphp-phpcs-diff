<?php

declare(strict_types=1);

namespace Desyncr\GrumPHP;

use GrumPHP\Extension\ExtensionInterface;
use Desyncr\GrumPHP\Task\PhpcsDiff;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class Extension implements ExtensionInterface
{
    public function load(ContainerBuilder $container): void
    {
        $container->register('task.phpcs-diff', PhpcsDiff::class)
            ->addArgument(new Reference('config'))
            ->addArgument(new Reference('process_builder'))
            ->addArgument(new Reference('formatter.raw_process'))
            ->addTag('grumphp.task', ['config' => 'phpcs-diff']);
    }
}
