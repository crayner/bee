<?php

namespace Busybee\SecurityBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;


/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class BusybeeSecurityExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
		
		$newContainer =  new ContainerBuilder();
		$loader = new Loader\YamlFileLoader($newContainer, new FileLocator(__DIR__.'/../Resources/config/menu'));
		$loader->load('parameters.yml');
		
		if ($container->getParameterBag()->has('menu')) 
		{
			$menu =  $container->getParameterBag()->get('menu', array()) ;
			$container->getParameterBag()->remove('menu');
		} else
			$menu = array();
		
		$container->getParameterBag()
			->set('menu', array_merge($menu, $newContainer->getParameterBag()->get('menu')));
	}
}
