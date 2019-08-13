<?php

namespace Api\Entities;

use \Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{

    protected $table = 'tournament';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',  'description',  'teams', 'groups'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'teams' => 'number',
        'groups' => 'number',
    ];

    public function teamsPerGroup()
    {
        return $this->teams / $this->groups;
    }

    public function tteams()
    {
        return $this->hasMany(TournamentTeam::class);
    }

    public function tmatchs()
    {
        return $this->hasMany(TournamentMatch::class);
    }

    public function tgroups()
    {
        return $this->hasMany(TournamentGroup::class);
    }
}