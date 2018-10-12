<?php
/**
 * Created by PhpStorm.
 * User: cipri
 * Date: 16/08/2018
 * Time: 09:32
 */

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension implements GlobalsInterface
{
    /**
     * @var string
     */
    private $locale;

    public function __construct(string $locale)
    {
        $this->locale = $locale;
    }

    public function getFilters()
    {
        //cream un nou filtru cu numele price care apeleaza metoda priceFilter din aceasta clasa
        return [
            new TwigFilter('price', [$this, 'priceFilter'])
        ];
    }

    public function getGlobals()
    {
        return [
            'locale' => $this->locale
        ];
    }

    public function priceFilter($number)
    {
        //ar trebui creat ca serviciu, insa pentru faptul ca folosim configurarile default,
        //acest lucru se realizeaza automat
        return '$' . number_format($number, 2, '.', ',');
    }
}