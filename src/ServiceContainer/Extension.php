<?php
/**
 * Copyright
 */

namespace Timitao\BehatAggregateContainer\ServiceContainer;

use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Behat\Testwork\ServiceContainer\ServiceProcessor;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class Extension implements ExtensionInterface
{

    /**
     * Prefix of extension
     */
    const EXTENSION_NAME = 'aggregate_container_extension';

    /**
     * ID of main aggregate
     */
    const EXTENSION_AGGREGATE_ROOT_ID = 'aggregate_container_extension.aggregate_id';

    /**
     * Tag name, that services should add
     */
    const EXTENSION_NAME_TAG = 'aggregate_container_extension.aggregate_tag';

    /**
     * @var ServiceProcessor
     */
    private $processor;

    /**
     * @param ServiceProcessor|null $processor
     */
    public function __construct(ServiceProcessor $processor = null)
    {
        $this->processor = $processor ?: new ServiceProcessor();
    }

    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $references = $this->processor->findAndSortTaggedServices($container, self::EXTENSION_NAME_TAG);

        $definition = $container->getDefinition(Extension::EXTENSION_AGGREGATE_ROOT_ID);
        foreach ($references as $reference) {
            $definition->addMethodCall('registerAggregate', array($reference));
        }
    }

    /**
     * @return string
     */
    public function getConfigKey()
    {
        return self::EXTENSION_NAME;
    }

    /**
     * @param ExtensionManager $extensionManager
     */
    public function initialize(ExtensionManager $extensionManager)
    {
    }

    /**
     * @param ArrayNodeDefinition $builder
     */
    public function configure(ArrayNodeDefinition $builder)
    {
    }

    /**
     * @param ContainerBuilder $container
     * @param array $config
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $container->setParameter(Extension::EXTENSION_NAME . '.config', $config);
    }
}
