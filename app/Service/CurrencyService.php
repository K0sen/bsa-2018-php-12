<?php

namespace App\Service;

use App\Entity\Currency;
use App\Repository\CurrencyRepository;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class CurrencyService
{
    private $currencyRepository;

    /**
     * CurrencyService constructor.
     *
     * @param CurrencyRepository $currencyRepository
     */
    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * @return Currency[]
     */
    public function getCurrencyList(): array
    {
        return $this->currencyRepository->findAll()->toArray();
    }

    /**
     * @param $id
     * @return Currency
     */
    public function findById($id): Currency
    {
        if (!$currency = $this->currencyRepository->getById($id)) {
            throw new NotFoundResourceException('Currency was not found');
        }

        return $currency;
    }

    public function shortNameAndActualPriceUpdate($name, float $price, $id)
    {
        $currency = $this->currencyRepository->getById($id);
        if (!$currency) {
            throw new NotFoundResourceException('Currency was not found');
        }

        return $this->currencyRepository->update($currency->fill([
            'short_name' => $name,
            'actual_course' => $price
        ]));
    }
}
