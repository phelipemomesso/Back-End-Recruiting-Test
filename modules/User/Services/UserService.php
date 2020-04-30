<?php

namespace Modules\User\Services;

use Fndmiranda\SimpleAddress\Facades\Address;
use Illuminate\Support\Arr;
use Modules\Core\Services\BaseService;
use Modules\User\Criteria\UserCriteria;
use Modules\User\Repositories\UserRepository;

class UserService extends BaseService
{
    /**
     * The repository instance.
     *
     * @var UserRepository
     */
    protected $repository = UserRepository::class;

}
