<?php

namespace Api\Http\Resources;

class Tournament extends Api
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'teams' => $this->teams,
            'groups' => $this->groups,
            'matches' => TournamentMatch::collection($this->tmatchs),
            'groups' => TournamentGroup::collection($this->tgroups),
            'teams' => TournamentTeam::collection($this->tteams),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
