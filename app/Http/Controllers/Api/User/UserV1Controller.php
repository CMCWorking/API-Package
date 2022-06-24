<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\UserTransformer;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserAPIRequest;
use App\Models\User;
use Dingo\Api\Routing\Helpers;

class UserV1Controller extends Controller
{
    use Helpers;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $user = $this->user->paginate(10);

        return $this->response->paginator($user, new UserTransformer());
    }

    public function show($id)
    {
        $user = $this->user->find($id);

        return $this->response->item($user, new UserTransformer());
    }

    public function store(UserAPIRequest $request)
    {
        $user = $this->user->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return $this->response->item($user, new UserTransformer());
    }

    public function update(UserAPIRequest $request, $id)
    {
        $user = $this->user->find($id);
        if (!$user) {
            return $this->response->errorNotFound('User not found');
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return $this->response->array([
            'message' => 'User updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $user = $this->user->find($id);
        if (!$user) {
            return $this->response->errorNotFound('User not found');
        }

        $user->delete();

        return $this->response->array([
            'message' => 'User deleted successfully',
        ]);
    }
}
