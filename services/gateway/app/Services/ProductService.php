<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;
use Illuminate\Support\Facades\Config;

class ProductService
{
    use ConsumesExternalService;

    protected $baseUri;
    protected $prefix;

    public function __construct()
    {
        $this->baseUri = Config::get('product.base_uri');
        $this->prefix = Config::get('product.prefix');
    }

    /**
     * @return array
     */
    public function getUsersList()
    {
        $response = $this->performRequest('GET', 'users');
        return $response->json();
    }
}


