<?php

namespace App\Http\Controllers;


use App\Service\CurrencyService;

class JsonRpcController extends Controller
{
    private $currencyService;

    /**
     * JsonRpcController constructor.
     * @param CurrencyService $currencyService
     */
    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCurrencyList()
    {
        return response()->json($this->currencyService->getCurrencyList());
    }

    /**
     * @param       $name
     * @param float $price
     * @param       $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function shortNameAndActualPriceUpdate($name, float $price, $id)
    {
        $updatedCurrency = $this->currencyService
            ->shortNameAndActualPriceUpdate($name, $price, $id);

        return response()->json($updatedCurrency);
    }

    public function getCurrency($id)
    {
        return response()->json($this->currencyService->findById($id));
    }
}