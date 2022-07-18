<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FriendCollection extends ResourceCollection
{
    // 通常、単数形を自動で取得するが、Friend.phpはEloquentで使っているので、別途指定する
    public $collects = 'App\Http\Resources\FriendResource';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection;
    }
}
