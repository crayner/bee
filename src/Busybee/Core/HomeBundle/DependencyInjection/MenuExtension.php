<?php

namespace Busybee\Core\HomeBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Config\FileLocator;

trait MenuExtension
{
	/**
	 * @param                  $dir
	 * @param ContainerBuilder $container
	 *
	 * @return ContainerBuilder
	 */
	public function buildMenu($dir, ContainerBuilder $container)
	{
		if (is_dir($dir . '/../Resources/config/menu') && is_file($dir . '/../Resources/config/menu/parameters.yml'))
		{
			$newContainer = new ContainerBuilder();
			$loader       = new Loader\YamlFileLoader($newContainer, new FileLocator($dir . '/../Resources/config/menu'));
			$loader->load('parameters.yml');

			if ($container->getParameterBag()->has('nodes'))
			{
				$menu = $container->getParameterBag()->get('nodes', array());
				$container->getParameterBag()->remove('nodes');
			}
			else
				$menu = [];

			$container->getParameterBag()
				->set('nodes', $this->arrayMerge($menu, $newContainer->getParameterBag()->has('nodes') ? $newContainer->getParameterBag()->get('nodes') : array()));

			if ($container->getParameterBag()->has('items'))
			{
				$menu = $container->getParameterBag()->get('items', array());
				$container->getParameterBag()->remove('items');
			}
			else
				$menu = [];

			$container->getParameterBag()
				->set('items', $this->arrayMerge($menu, $newContainer->getParameterBag()->has('items') ? $newContainer->getParameterBag()->get('items') : array()));

			if ($container->getParameterBag()->has('sections'))
			{
				$sections = $container->getParameterBag()->get('sections', []);
				$container->getParameterBag()->remove('sections');
			}
			else
				$sections = [];

			$container->getParameterBag()
				->set('sections', $this->sectionMerge($sections, $newContainer->getParameterBag()->has('sections') ? $newContainer->getParameterBag()->get('sections') : []));

			$sections = $container->getParameterBag()
				->get('sections', []);

			$routes = [];

			foreach ($sections as $name => $header)
			{
				if (!is_array($header))
				{
					var_dump($sections);
					var_dump($name);
					var_dump($header);
					die();
				}
				foreach ($header as $headName => $data)
					if ($headName !== 'hidden')
					{
						foreach ($data as $x)
						{
							$key                     = $x['route'];
							$routes[$key]['section'] = $name;
							$routes[$key]['header']  = $headName;
						}
					}
					else
					{
						foreach ($data as $key)
						{
							$routes[$key]['section'] = $name;
							$routes[$key]['header']  = $headName;
						}
					}
			}

			$container->getParameterBag()
				->set('sectionRoutes', $routes);

		}

		return $container;
	}

	/**
	 * @param array $a1
	 * @param array $a2
	 *
	 * @return array
	 */
	protected function arrayMerge(array $a1, array $a2): array
	{
		foreach ($a2 as $q => $w)
			if (!array_key_exists($q, $a1))
				$a1[$q] = $w;

		return $a1;
	}

	/**
	 * @param array $a1
	 * @param array $a2
	 *
	 * @return array
	 */
	protected function sectionMerge(array $a1, array $a2): array
	{
		foreach ($a2 as $q => $w)
		{
			if (!array_key_exists($q, $a1))
				$a1[$q] = $w;
			else
				$a1[$q] = $this->sectionMerge($a1[$q], $w);
		}

		return $a1;
	}

}
