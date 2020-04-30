<?php

namespace Modules\User\Http\Resources;

use Fndmiranda\SimpleAddress\Http\Resources\AddressResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Balance\Http\Resources\BalanceResource;
use Modules\Bank\Http\Resources\BankResource;
use Modules\Phone\Http\Resources\PhoneResource;
use Modules\Place\Http\Resources\PlaceResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'nickname' => $this->nickname,
            'first_name' => $this->first_name,
            'email' => $this->email,
            'avatar' => $this->avatar,
            'email_verified_at' => $this->email_verified_at,
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
            'balance' => BalanceResource::make($this->whenLoaded('balance')),
            'places' => PlaceResource::collection($this->whenLoaded('places')),
            'addresses' => AddressResource::collection($this->whenLoaded('addresses')),
            'phones' => PhoneResource::collection($this->whenLoaded('phones')),
            'phone' => PhoneResource::make($this->whenLoaded('phone')),
            'roles' => $this->whenLoaded('roles', function () {
                return [
                    'is_active' => $this->roles->is_active,
                    'is_superuser' => $this->roles->is_superuser,
                    'is_staff' => $this->roles->is_staff,
                    'is_customer' => $this->roles->is_customer,
                    'created_at' => $this->roles->created_at->toIso8601String(),
                    'updated_at' => $this->roles->updated_at->toIso8601String(),
                ];
            }),
            'bank_accounts' => BankResource::collection($this->whenLoaded('bankAccounts')),
        ];
    }
}
