<?php

namespace Api\Entities;

use \Illuminate\Database\Eloquent\Model;

class TournamentGroup extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tournament_id', 'name', 'team',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'team' => 'string',
        'tournament_id' => 'number',
    ];
    
    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }
}