<?php

namespace Modules\Core\Http\Controllers;

use Exception;
use Fndmiranda\SimpleAddress\Http\Resources\AddressResource;
use Illuminate\Routing\Controller;
use Fndmiranda\SimpleAddress\Facades\Address;
use Illuminate\Support\Facades\Log;

class AddressController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param string $postcode
     * @return AddressResource
     */
    public function show($postcode)
    {
        if ($address = $this->address($postcode)) {
            return AddressResource::make($address);
        }

        return abort(404);
    }

    /**
     * Search address by postcode.
     *
     * @param $postcode
     * @return array
     */
    private function address($postcode)
    {
        try {
            return Address::search($postcode);
        } catch (Exception $e) {
            Log::error('Error to search address by postcode', ['postcode' => $postcode]);
        }
    }
}
