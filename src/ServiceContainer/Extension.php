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

    const EXTENSION_NAME = 'aggregate_container_extension';

    /**
     * ID of main aggregate
     */
    const EXTENSION_AGGREGATE_ROOT_ID = 'aggregate_container_extension.aggregate_id';

    /**
     * Tag name, that services should add
     */
    const EXTENSION_NAME_TAG = 'aggregate_container_extension.aggregate_tag';

    /** @var ServiceProcessor */
    private $processor;

    public function __construct(ServiceProcessor $processor = null)
    {
        $this->processor = $processor ?: new ServiceProcessor();
    }

    public function process(ContainerBuilder $container)
    {
        $references = $this->processor->findAndSortTaggedServices($container, self::EXTENSION_NAME_TAG);

        $definition = $container->getDefinition(Extension::EXTENSION_AGGREGATE_ROOT_ID);
        foreach ($references as $reference) {
            $definition->addMethodCall('registerAggregate', array($reference));
        }
    }

    public function getConfigKey()
    {
        return self::EXTENSION_NAME;
    }

    public function initialize(ExtensionManager $extensionManager)
    {

    }

    public function configure(ArrayNodeDefinition $builder)
    {

    }

    public function load(ContainerBuilder $container, array $config)
    {
        $container->setParameter(Extension::EXTENSION_NAME . '.config', $config);
    }
}