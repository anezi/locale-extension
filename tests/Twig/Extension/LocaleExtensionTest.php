<?php

declare(strict_types=1);

namespace Anezi\Locale\Twig\Extension;

use PHPUnit\Framework\TestCase;

class LocaleExtensionTest extends TestCase
{
    /**
     * @var \Twig_Loader_Array
     */
    private $loader;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function setUp()
    {
        \Locale::setDefault('en');

        $this->loader = new \Twig_Loader_Array([]);

        $this->twig = new \Twig_Environment($this->loader);

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
}
