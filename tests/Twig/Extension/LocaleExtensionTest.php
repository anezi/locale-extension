<?php

/*
 * (c) Hassan Amouhzi <hassan@anezi.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


declare(strict_types=1);

namespace Anezi\Locale\Twig\Extension;

use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

/**
 * @author  Hassan Amouhzi <hassan@anezi.net>
 */
class LocaleExtensionTest extends TestCase
{
    /**
     * @var \Twig_Loader_Array|ArrayLoader
     */
    private $loader;

    /**
     * @var \Twig_Environment|Environment
     */
    private $twig;

    protected function setUp(): void
    {
        \Locale::setDefault('en');

        $this->loader = $this->createTwigLoaderArray();

        $this->twig = $this->createTwigEnvironment();

        $this->twig->addExtension(new LocaleExtension(['ar', 'en', 'fr']));
    }

    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function testLocalesFunction(): void
    {
        $this->loader->setTemplate(
            'template',
            '{% for locale in locales() %}{{ locale }} - {% endfor %}'
        );

        $this->assertSame('ar - en - fr - ', $this->twig->render('template'));
    }

    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function testCountryNameFilter(): void
    {
        $this->loader->setTemplate(
            'template',
            '{{ "be"|country_name }}'
        );

        $this->assertSame('Belgium', $response = $this->twig->render('template'));
    }

    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function testLocaleNameFilter(): void
    {
        $this->loader->setTemplate(
            'template',
            '{{ "fr_BE"|locale_name }}'
        );

        $this->assertSame('French (Belgium)', $response = $this->twig->render('template'));
    }

    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function testOriginLocaleNameFilter(): void
    {
        $this->loader->setTemplate(
            'template',
            '{{ "fr_BE"|origin_locale_name }}'
        );

        $this->assertSame('français (Belgique)', $response = $this->twig->render('template'));
    }

    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function testLocaleShortNameNameFilter(): void
    {
        $this->loader->setTemplate(
            'template',
            '{{ "fr_BE"|locale_short_name }}'
        );

        $this->assertSame('fr', $response = $this->twig->render('template'));
    }

    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function testHtmlDirFilter(): void
    {
        $this->loader->setTemplate(
            'template',
            '{{ "fr_BE"|html_dir }} - {{ "ar"|html_dir }}'
        );

        $this->assertSame('ltr - rtl', $response = $this->twig->render('template'));
    }

    private function createTwigLoaderArray()
    {
        if (class_exists('Twig_Loader_Array')) {
            return new \Twig_Loader_Array([]);
        }

        return new ArrayLoader();
    }

    private function createTwigEnvironment()
    {
        if (class_exists('Twig_Environment')) {
            return new \Twig_Environment($this->loader);
        }

        return new Environment($this->loader);
    }
}
