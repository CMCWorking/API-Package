<?php

namespace App\Http\Controllers\Api\Status;

use App\Models\Status;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use App\Transformer\StatusTransformer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class StatusV1Controller extends Controller
{
    use Helpers;

    public function __construct(Status $status)
    {
        $this->middleware('auth:sanctum');
        $this->page = 10;
    }

    public function index(Request $request)
    {
        $statuses = $this->status->filter($request->all())->paginate($request->paginate ?? $this->page);

        if (count($statuses) < 1) {
            return $this->response->errorNotFound('Statuses not found');
        }

        return $this->response->paginator($statuses, new StatusTransformer());
    }

    public function show($id)
    {
        $status = $this->status->find($id);

        return $this->response->item($status, new StatusTransformer());
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('create-statuses')) {
            return $this->response->AccessDeniedHttpException('You are not allowed to create statuses.');
        }

        $status = $this->status->create([
            'name' => $request->name,
            'description' => $request->description,
            'classname' => $request->classname,
            'type' => $request->type,
        ]);

        return $this->response->item($status, new StatusTransformer());
    }

    public function update(Request $request, $id)
    {
        $status = $this->status->find($id);

        if (!$status) {
            return $this->response->errorNotFound('Status not found');
        }

        if (!auth()->user()->can('update-statuses')) {
            return $this->response->AccessDeniedHttpException('You are not allowed to update statuses.');
        }

        $status->update([
            'name' => $request->name,
            'description' => $request->description,
            'classname' => $request->classname,
            'type' => $request->type,
        ]);

        return $this->response->item($status, new StatusTransformer());
    }

    public function destroy($id)
    {
        $status = $this->status->find($id);

        if (!$status) {
            return $this->response->errorNotFound('Status not found');
        }

        if (!auth()->user()->can('delete-statuses')) {
            return $this->response->AccessDeniedHttpException('You are not allowed to delete statuses.');
        }

        $status->delete();

        return $this->response->noContent();
    }

    public function search(Request $request)
    {
        $status = $this->status->filter($request->all())->paginate($request->paginate ?? $this->page);

        if (count($status) < 1) {
            return $this->response->errorNotFound('Status not found');
        }

        return $this->response->paginator($status, new StatusTransformer());
    }
}
