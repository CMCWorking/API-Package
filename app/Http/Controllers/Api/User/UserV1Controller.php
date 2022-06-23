<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\UserTransformer;
use App\Http\Controllers\Controller;
use App\Models\User;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class UserV1Controller extends Controller
{
    use Helpers;

    public function index()
    {
        $user = User::paginate(10);

        return $this->response->paginator($user, new UserTransformer());
    }

    public function show($id)
    {
        $user = User::find($id);

        return $this->response->item($user, new UserTransformer());
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ];

        $payload = app('request')->only(['name', 'email', 'password']);

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException('Could not create new user.', $validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return $this->response->array([
            'message' => 'User created successfully',
        ]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => ['string'],
            'email' => ['email', 'unique:users'],
            'password' => ['string', 'min:8'],
        ];

        $payload = app('request')->only(['name', 'email', 'password']);

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException('Could not update user.', $validator->errors());
        }

        $user = User::find($id);
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
        $user = User::find($id);
        if (!$user) {
            return $this->response->errorNotFound('User not found');
        }

        $user->delete();

        return $this->response->array([
            'message' => 'User deleted successfully',
        ]);
    }
}
