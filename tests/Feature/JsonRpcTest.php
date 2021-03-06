<?php

namespace Tests\Feature;

use App\Entity\Currency;
use App\Http\Controllers\JsonRpcController;
use App\Repository\CurrencyRepository;
use App\Service\CurrencyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Thiagof\LaravelRPC\RpcClientFacade;

class JsonRpcTest extends TestCase
{
    use RefreshDatabase;

    private $currencyRepository;
    private $currencyService;

    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->currencyRepository = new CurrencyRepository();
        $this->currencyService = new CurrencyService($this->currencyRepository);

        factory(Currency::class, 5)->create();
        app('config')->set('rpc.client.url', 'http://localhost');
    }

    public function testGetCurrency()
    {
        $payload = '{"jsonrpc": "2.0", "method": "detail", "params": [5], "id": 1}';
        $server = app()->make('JsonRpcServer', [$payload]);
        $server->attach(new JsonRpcController($this->currencyService));
        $response = json_decode($server->execute(), true);
        $currency = $response['result']['original'];

        $this->assertEquals(5, $currency['id']);
        $this->assertTrue(isset($currency['short_name'], $currency['actual_course']));
    }

    /**
     * The test is crashes when run all tests together, but if run this single test - he's ok... TODO
     */
    public function testUpdateCurrency()
    {
        $payload = '{"jsonrpc": "2.0", "method": "update", "params": ["BitCoIn", 6969.69, 4], "id": 2}';
        $server = app()->make('JsonRpcServer', [$payload]);
        $server->attach(new JsonRpcController($this->currencyService));
        dump($server);
        $response = json_decode($server->execute(), true);
        $currency = $response['result']['original'];

        $this->assertEquals('BitCoIn', $currency['short_name']);
        $this->assertEquals(6969.69, $currency['actual_course']);
    }

    public function testGetCurrencies()
    {
        $payload = '{"jsonrpc": "2.0", "method": "list", "id": 3}';
        $server = app()->make('JsonRpcServer', [$payload]);
        $server->attach(new JsonRpcController($this->currencyService));
        $response = json_decode($server->execute(), true);
        $firstFoundCurrency = $response['result']['original'][0];

        $this->assertTrue(isset($firstFoundCurrency['short_name']));
    }

    public function testDelete()
    {
        $payload = '{"jsonrpc": "2.0", "method": "delete", "params": [3], "id": 4}';
        $server = app()->make('JsonRpcServer', [$payload]);
        $server->attach(new JsonRpcController($this->currencyService));
        $server->execute();

        $this->assertDatabaseMissing('currencies', [
            'id' => 3,
        ]);
    }
}
