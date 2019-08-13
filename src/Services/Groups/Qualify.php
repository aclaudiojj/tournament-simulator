<?php

namespace Api\Services\Groups;

class Qualify
{

    private $repository;

    private $groups;

    private $qMatches;

    public function init($repository)
    {
        $this->repository = $repository;
    }

    public function getMatches()
    {
        return $this->qMatches;
    }

    public function simulate($tournament, $groups)
    {
        $matches = [];

        foreach ($groups as $groupName => $teamsInGroup) {
            $matches[$groupName] = $this->matchesPerGroup($tournament, $groupName, $teamsInGroup, 'qualify');
        }

        return $matches;
    }

    public function matchesPerGroup($tournament, $groupName, $teamsInGroup, $matchType)
    {
        $matches = [];

        foreach ($teamsInGroup as $team1) {
            $team1Name = $team1->team;

            foreach ($teamsInGroup as $team2) {
                
                if ($team2->team == $team1->team) {
                    continue;
                }

                $matchName = implode(' x ', \Arr::sort([$team1->team, $team2->team]));

                if (!empty($matches[$matchName])) {
                    continue;
                }

                if (rand(1,2) % 2 == 0) {
                    $team1Score = 16;
                    $team2Score = random_int(0, 14);
                } else {
                    $team2Score = 16;
                    $team1Score = random_int(0, 14);
                }

                $this->qMatches[] = $team1->team . ' ' . $team1Score . ' x ' . $team2Score . ' ' . $team2->team;

                $matches[$matchName] = $this->repository->init([
                    'team_1' => $team1->team,
                    'team_2' => $team2->team,
                    'team_1_score' => $team1Score,
                    'team_2_score' => $team2Score,
                    'stage' => $matchType,
                    'tournament_id' => $tournament->id,
                    
                ])->storeRaw();
            }
        }

        return $matches;
    }

    public function createGroups($tournament, $teams)
    {
        $teamsPerGroup = $teams->count() / $tournament->groups;

        $group = 1;
        $teamsInGroup = 0;

        foreach ($teams as $key => $team) {
            if ($teamsInGroup == $teamsPerGroup) {
                $group++;
                $teamsInGroup = 0;
            }

            $groupName = 'Group ' . $group;

            $this->repository->init([
                'team' => $team->team,
                'name' => 'Group ' . $group,
                'tournament_id' => $tournament->id,
            ])->storeRaw();

            $groups[$groupName][] = $team;
            $this->groups[$groupName][] = $team->team;

            $teamsInGroup++;
        }

        return $groups;
    }

    public function getTeamsAndGroups()
    {
        return $this->groups;
    }
}