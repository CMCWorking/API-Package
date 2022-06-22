<?php
namespace App\Http\Controllers\Api\Status;

use App\Models\Status;
use League\Fractal\TransformerAbstract;

class StatusTransformer extends TransformerAbstract
{
    public function transform(Status $status)
    {
        return [
            'name' => $status['name'],
            'description' => $status['description'],
            'className' => $status['classname'],
            'type' => $status['type'],
        ];
    }
}
