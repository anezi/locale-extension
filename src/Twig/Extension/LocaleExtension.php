<?php

declare(strict_types=1);

namespace Anezi\Locale\Twig\Extension;

use Symfony\Component\Intl\Intl;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class LocaleExtension.
 *
 * @author  Hassan Amouhzi <hassan@amouhzi.com>
 * @license Proprietary See License file.
 */
class LocaleExtension extends AbstractExtension
{
    /**
     * @var array
     */
    private $locales;

    /**
     * @param array $locales The locale.
     */
    public function __construct(array $locales)
    {
        $this->locales = $locales;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('locales', [$this, 'getLocales']),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('country_name', [$this, 'getCountryName']),
            new TwigFilter('locale_name', [$this, 'getLocaleName']),
            new TwigFilter('origin_locale_name', [$this, 'getOriginLocaleName']),
        ];
    }

    /**
     * @return array
     */
    public function getLocales(): array
    {
        return $this->locales;
    }

    /**
     * @param string $countryCode The country code.
     *
     * @return string
     */
    public function getCountryName(string $countryCode): string
    {
        return Intl::getRegionBundle()->getCountryName(\strtoupper($countryCode));
    }

    /**
     * @param string $locale The locale.
     *
     * @return string
     */
    public function getLocaleName(string $locale): string
    {
        return Intl::getLocaleBundle()->getLocaleName($locale);
    }

    /**
     * @param string $locale The locale.
     *
     * @return string
     */
    public function getOriginLocaleName(string $locale): ?string
    {
        return Intl::getLocaleBundle()->getLocaleName($locale, $locale);
    }
}
