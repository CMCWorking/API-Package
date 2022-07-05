<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAPIRequest;
use App\Models\User;
use App\Transformer\UserTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UserV1Controller extends Controller
{
    use Helpers;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->page = 10;
    }

    public function index()
    {
        $users = $this->user->paginate(10);

        return $this->response->paginator($users, new UserTransformer());
    }

    public function show($id)
    {
        $user = $this->user->find($id);

        return $this->response->item($user, new UserTransformer());
    }

    public function store(UserAPIRequest $request)
    {
        if (!auth()->user()->can('create-users')) {
            return $this->response->AccessDeniedHttpException('You are not allowed to create users.');
        }

        $user = $this->user->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return $this->response->item($user, new UserTransformer());
    }

    public function update(UserAPIRequest $request, $id)
    {
        if (!auth()->user()->can('update-users')) {
            return $this->response->AccessDeniedHttpException('You are not allowed to update users.');
        }

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
        if (!auth()->user()->can('delete-users')) {
            return $this->response->AccessDeniedHttpException('You are not allowed to delete users.');
        }

        $user = $this->user->find($id);
        if (!$user) {
            return $this->response->errorNotFound('User not found');
        }

        $user->delete();

        return $this->response->array([
            'message' => 'User deleted successfully',
        ]);
    }

    public function search(Request $request)
    {
        $users = $this->user->filter($request->all())->Sortable($request->sort)->paginate($request->paginate ?? $this->page);

        if (count($users) < 1) {
            return $this->response->errorNotFound('User not found');
        }

        return $this->response->paginator($users, new UserTransformer());
    }
}
