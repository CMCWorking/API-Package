<?php
namespace App\Transformer;

use App\Models\Status;
use League\Fractal\TransformerAbstract;

class StatusTransformer extends TransformerAbstract
{
    public function transform(Status $status)
    {
        return [
            'id' => $status['id'],
            'name' => $status['name'],
            'description' => $status['description'],
            'className' => $status['classname'],
            'type' => $status['type'],
        ];
    }
}
