<?php
namespace TopShelfCraft\Wordsmith\view;

use TopShelfCraft\Wordsmith\Wordsmith;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;

class WordsmithTwigExtension extends AbstractExtension implements GlobalsInterface
{

	/**
	 * Returns the name of the extension.
	 *
	 * @return string The extension name
	 */
	public function getName(): string
	{
		return 'Wordsmith';
	}

	/**
	 * Returns an array of Twig filters, to be used in Twig templates via:
	 *
	 *      {{ 'bar' | fooFilter }}
	 *
	 * @return array
	 */
	public function getFilters(): array
	{

		$smith = Wordsmith::getInstance()->smith;
		$prefix = Wordsmith::getInstance()->getSettings()->twigPrefix;

		$filters = [];

		foreach ($smith->getMethodList() as $method => $meta)
		{
			$filters[] = new TwigFilter($prefix . $method, [$smith, $method], $meta);
		}

		return $filters;

	}

	/**
	 * Returns an array of Twig functions, used in Twig templates via:
	 *
	 *      {% set fizz = fooFunction('buzz') %}
	 *
	 * @return array
	 */
	public function getFunctions(): array
	{

		$smith = Wordsmith::getInstance()->smith;
		$prefix = Wordsmith::getInstance()->getSettings()->twigPrefix;

		$functions = [];

		foreach ($smith->getMethodList() as $method => $meta)
		{
			$functions[] = new TwigFunction($prefix . $method, [$smith, $method], $meta);
		}

		return $functions;

	}

	/**
	 * @inheritdoc
	 */
	public function getGlobals(): array
	{
		return ['wordsmith' => Wordsmith::getInstance()->smith];
	}

}
