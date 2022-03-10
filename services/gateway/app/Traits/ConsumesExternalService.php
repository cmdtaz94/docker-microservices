<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

trait ConsumesExternalService
{

    /**
     * Send a request to any service
     * @param string $method
     * @param array $formParams
     * @param array $headers
     * @return object
     * @throws \Exception
     */
    public function performRequest($method, $requestUri, $formParams = [], $headers = [])
    {
        $request = Http::withHeaders($headers);

        return $request->{Str::lower($method)}("$this->baseUri/$this->prefix/" . $requestUri, $formParams)
            ->throw();
    }
}
