<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;

class FriendsRelationship extends Model
{
    protected $table = 'friends_relationships';

    protected $fillable = [
        'own_friends_id',
        'other_friends_id',
    ];

    public function friends()
    {
        return $this->belongsTo(\App\Eloquents\Friend::class, 'own_friends_id', 'id');
    }
}
