<?php

namespace ServerGrove\Bundle\TranslationEditorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('server_grove_translation_editor');

        $supportedStorages = array('orm');

        $rootNode
            ->children()
                ->arrayNode('storage')
                    ->children()
                        ->scalarNode('type')
                            ->validate()
                                ->ifNotInArray($supportedStorages)
                                ->thenInvalid('The storage type "%s" is not supported. Please choose one of: ' . json_encode($supportedStorages))
                            ->end()
                            ->cannotBeOverwritten()
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('manager')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}