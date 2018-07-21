<?php

namespace App\Repository;

use App\Entity\Currency;
use App\Service\CurrencyService;
use Illuminate\Support\Collection;

class CurrencyRepository
{
    /**
     * @return Collection
     */
    public function findAll(): Collection
    {
        return Currency::all();
    }

    /**
     * @param int $id
     * @return Currency|null
     */
    public function getById(int $id): ?Currency
    {
        return Currency::find($id);
    }

    /**
     * @param Currency $currency
     * @return Currency
     */
    public function update(Currency $currency): ?Currency
    {
        return $currency->save() ? $currency : null;
    }

    /**
     * @param Currency $currency
     * @return bool
     * @throws \Exception
     */
    public function delete(Currency $currency): bool
    {
        return $currency->delete();
    }
}
