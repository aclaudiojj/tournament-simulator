<?php

namespace Api\Services;

use Api\Contracts\ServiceContract;

class TournamentTeamService extends Service implements ServiceContract
{
    private $teams;

    public function createTeams(int $numberOfTeams)
    {
        return factory(\Api\Entities\TournamentTeam::class, $numberOfTeams)->make()->shuffle()->each(function($team) {
            $this->teams[] = $team->team;
        });
    }

    public function getTeamNames()
    {
        return $this->teams;
    }
}