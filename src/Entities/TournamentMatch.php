<?php

namespace Api\Entities;

use \Illuminate\Database\Eloquent\Model;

class TournamentMatch extends Model
{

    protected $table = 'tournament_games';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tournament_id', 'team_1', 'team_2', 'team_1_score', 'team_2_score', 'stage'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'team_1' => 'string',
        'team_2' => 'string',
        'team_1_score' => 'number',
        'team_2_score' => 'number',
        'stage' => 'string',
        'tournament_id' => 'number',

    ];
    
    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }
}