<?php

namespace Api\Repositories;

use Api\Entities\TournamentGroup;
use Illuminate\Database\Eloquent\Model;
use Api\Http\Resources\TournamentGroup as TournamentGroupResource;
use Api\Http\Resources\TournamentGroups as TournamentGroupsResource;
use Api\Http\Resources\Api as ApiResource;
use Api\Http\Resources\ApiCollection as ApiResources;
use Illuminate\Database\Eloquent\Collection;

class TournamentGroupRepository extends Repository
{   

    /**
     *
     * @param  \Api\Entities\TournamentGroup $tournament
     */
    public function __construct(TournamentGroup $tournamentGroup)
    {
        $this->model = $tournamentGroup;
    }

    public function clear()
    {
        \DB::delete('delete from tournament_groups');
    }

    public function canBeAddedToGroup(int $tournament, string $group)
    {
        $teamsInGroup = $this->model->where('tournament_id', $tournament)->where('name', $group)->get();

        $numberOfTeamsInGroup = $teamsInGroup->count();

        if (empty($numberOfTeamsInGroup)) {
            return true;
        }

        $maxTeamsPerGroup = $teamsInGroup->first()->tournament()->first()->teamsPerGroup();

        return $numberOfTeamsInGroup < $maxTeamsPerGroup;
    }

    /**
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return \Api\Http\Resources\Api
     */
    public function resource(Model $tournament) : ApiResource
    {
        return new TournamentGroupResource($tournament);
    }

    /**
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return \Api\Http\Resources\ApiCollection
     */
    public function resources(Collection $tournaments) : ApiResources
    {
        return new TournamentGroupsResource($tournaments);
    }

}