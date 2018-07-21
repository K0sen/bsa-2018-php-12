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
    public function list()
    {
        return response()->json($this->currencyService->getCurrencyList());
    }

    /**
     * @param       $name
     * @param float $price
     * @param       $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($name, float $price, $id)
    {
        $updatedCurrency = $this->currencyService
            ->shortNameAndActualPriceUpdate($name, $price, $id);

        return response()->json($updatedCurrency);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail($id)
    {
        return response()->json($this->currencyService->findById($id));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete($id)
    {
        if ($this->currencyService->delete($id)) {
            return response()->json('Currency was successfully removed');
        }

        return response()->json('Currency was not removed for some reason', 404);
    }
}
