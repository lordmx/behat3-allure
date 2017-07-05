<?php

namespace BehatAllure\Behat;

use Behat\Testwork\Exception\ExceptionPresenter;
use Behat\Testwork\Exception\ServiceContainer\ExceptionExtension;
use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class BehatAllureFormatterExtension
 *
 * @package BehatAllure\Behat
 */
class BehatAllureFormatterExtension implements ExtensionInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {

    }

    /**
     * Returns the extension config key.
     *
     * @return string
     */
    public function getConfigKey()
    {
        return 'allure';
    }

    /**
     * Initializes other extensions.
     *
     * This method is called immediately after all extensions are activated but
     * before any extension `configure()` method is called. This allows extensions
     * to hook into the configuration of other extensions providing such an
     * extension point.
     *
     * @param ExtensionManager $extensionManager
     */
    public function initialize(ExtensionManager $extensionManager) {

    }

    /**
     * Setups configuration for the extension.
     *
     * @param ArrayNodeDefinition $builder
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        $builder->children()->scalarNode('name')->defaultValue('allure');
    }

    /**
     * Loads extension services into temporary container.
     *
     * @param ContainerBuilder $container
     * @param array $config
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $presenter = new Reference(ExceptionExtension::PRESENTER_ID);

        $definition = new Definition('BehatAllure\\Behat\\Formatter\\BehatAllureFormatter');
        $definition->addArgument($config['name']);
        $definition->addArgument('%paths.base%');
        $definition->addArgument($presenter);

        $container
            ->setDefinition('allure.formatter', $definition)
            ->addTag('output.formatter');
    }
}
