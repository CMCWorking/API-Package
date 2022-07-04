<?php

namespace App\Http\Controllers\Api\Role;

use App\Http\Controllers\Controller;
use App\Transformer\RoleTransformer;
use Dingo\Api\Routing\Helpers;
use Spatie\Permission\Models\Role;

class RoleV1Controller extends Controller
{
    use Helpers;

    public function __construct(Role $role)
    {
        $this->middleware('auth:api');
        $this->role = $role;
    }

    public function index()
    {
        $roles = $this->role->all();

        return $this->response->collection($roles, new RoleTransformer());
    }
}
