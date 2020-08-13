<?php

declare(strict_types=1);

namespace App\DependancyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ExceptionNormalizerPass implements CompilerPassInterface
 {
    public function process(ContainerBuilder $container)
    {
        $exceptionListenerDefinition = $container->findDefinition('blog_api.events.exception_subscriber');

        $normalisers = $container->findTaggedServiceIds('blog_api.normalizer');

        foreach ($normalisers as $normaliser => $tags) {
            $exceptionListenerDefinition->addMethodCall('addNormalizer', [new Reference($normaliser)]);
        }
    }
 }