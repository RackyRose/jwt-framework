<?php

declare(strict_types=1);

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2017 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace Jose\Bundle\JoseFramework\DependencyInjection\Source\KeyManagement\JWKSetSource;

use Jose\Bundle\JoseFramework\DependencyInjection\Source\AbstractSource;
use Jose\Component\KeyManagement\X5UFactory;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class X5U.
 */
final class X5U extends AbstractSource implements JWKSetSource
{
    /**
     * {@inheritdoc}
     */
    public function createDefinition(ContainerBuilder $container, array $config): Definition
    {
        $definition = new Definition(\Jose\Component\Core\JWKSet::class);
        $definition->setFactory([
            new Reference(X5UFactory::class),
            'loadFromUrl',
        ]);
        $definition->setArguments([
            $config['url'],
//            $config['headers'],
        ]);
        $definition->addTag('jose.jwkset');

        return $definition;
    }

    /**
     * {@inheritdoc}
     */
    public function getKeySet(): string
    {
        return 'x5u';
    }

    /**
     * {@inheritdoc}
     */
    public function addConfiguration(NodeDefinition $node)
    {
        parent::addConfiguration($node);
        $node
            ->children()
                ->scalarNode('url')
                    ->info('URL of the key set.')
                    ->isRequired()
                ->end()
            ->end();
    }
}