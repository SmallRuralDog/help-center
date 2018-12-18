<?php

namespace SmallRuralDog\HelpCenter\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class HelpWorkOrder extends Model
{
    protected $guarded = [];

    protected $casts = [
        'images' => 'json'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function replays()
    {
        return $this->hasMany(HelpWorkOrder::class, 'p_id')->orderBy('id');
    }
}
