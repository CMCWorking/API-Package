<?php

namespace App\Http\Controllers\Api\Status;

use App\Http\Controllers\Api\Status\StatusTransformer;
use App\Http\Controllers\Controller;
use App\Models\Status;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

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
        $status = Status::create([
            'name' => $request->name,
            'description' => $request->description,
            'classname' => $request->classname,
            'type' => $request->type,
        ]);

        return $this->response->created();
    }

    public function update(Request $request, $id)
    {
        $status = Status::find($id);

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

        $status->delete();

        return $this->response->noContent();
    }
}
