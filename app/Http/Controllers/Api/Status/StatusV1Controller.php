<?php

namespace App\Http\Controllers\Api\Status;

use App\Http\Controllers\Api\Status\StatusTransformer;
use App\Http\Controllers\Controller;
use App\Models\Status;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class StatusV1Controller extends Controller
{
    use Helpers;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $statuses = Status::all();

        return $this->response->collection($statuses, new StatusTransformer());
    }

    public function show($id)
    {
        $status = Status::find($id);

        return $this->response->item($status, new StatusTransformer());
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('create-statuses')) {
            return $this->response->AccessDeniedHttpException('You are not allowed to create statuses.');
        }

        $status = Status::create([
            'name' => $request->name,
            'description' => $request->description,
            'classname' => $request->classname,
            'type' => $request->type,
        ]);

        return $this->response->item($status, new StatusTransformer());
    }

    public function update(Request $request, $id)
    {
        $status = Status::find($id);

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
        $status = Status::find($id);

        if (!$status) {
            return $this->response->errorNotFound('Status not found');
        }

        if (!auth()->user()->can('delete-statuses')) {
            return $this->response->AccessDeniedHttpException('You are not allowed to delete statuses.');
        }

        $status->delete();

        return $this->response->noContent();
    }
}
