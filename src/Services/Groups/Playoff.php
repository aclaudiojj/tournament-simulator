<?php

namespace Api\Services\Groups;

class Playoff
{

    private $teams;

    private $repository;

    private $champion;

    private $pMatches;

    public function getTeams()
    {
        return $this->teams;
    }

    public function getMatches()
    {
        return $this->pMatches;
    }

    public function getChampion()
    {
        return $this->champion->team;
    }

    public function init($repository)
    {
        $this->repository = $repository;
    }

    private function teams($matches)
    {
        $teams = [];

        foreach ($matches as $matchName => $match) {
            $winner = ($match->team_1_score > $match->team_2_score ? $match->team_1 : $match->team_2);
            
            if (!isset($teams[$winner])) {
                $teams[$winner] = 0;
            }

            $teams[$winner]++;
        }

        $playoffers = array_reverse(array_slice(\Arr::sort($teams), count($teams)-2, 2));

        $teamsInPlayoffs = [];
        foreach ($playoffers as $teamName => $playoffer) {
            $this->teams[] = $teamName;
            $teamsInPlayoffs[] = app()->make(\Api\Entities\TournamentTeam::class)->fill([
                'team' => $teamName
            ]);
        }

        return $teamsInPlayoffs;
    }

    public function teamsInPlayoffs($tournament, $groupMatches)
    {
        $teamsInPlayoffs = [];

        foreach ($groupMatches as $group => $matches) {
            $teamsInPlayoffs = array_merge($teamsInPlayoffs, $this->teams($matches));
        }

        return $teamsInPlayoffs;
    }

    public function simulate($tournament, $playoffers)
    {
        if (count($playoffers) <= 1) {
            $this->champion = $playoffers[0];
            return;
        }

        $winners = [];

        while (! empty($playoffers)) {
            shuffle($playoffers);
            $team1 = array_pop($playoffers);

            shuffle($playoffers);
            $team2 = array_pop($playoffers);
            
            if (rand(1,2) % 2 == 0) {
                $winners[] = $team1;
                $team1Score = 16;
                $team2Score = random_int(0, 14);
            } else {
                $winners[] = $team2;
                $team2Score = 16;
                $team1Score = random_int(0, 14);
            }

            $this->pMatches[] = $team1->team . ' ' . $team1Score . ' x ' . $team2Score . ' ' . $team2->team;

            $this->repository->init([
                'team_1' => $team1->team,
                'team_2' => $team2->team,
                'team_1_score' => $team1Score,
                'team_2_score' => $team2Score,
                'stage' => 'playoff',
                'tournament_id' => $tournament->id,
                
            ])->storeRaw();
        }

        $this->simulate($tournament, $winners);
    }
}