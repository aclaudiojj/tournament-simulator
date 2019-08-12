<?php

namespace Api\Services;

use Api\Contracts\ServiceContract;
use Api\Repositories\TournamentMatchRepository;
use Api\Services\Groups\Qualify;
use Api\Services\Groups\Playoff;

class TournamentMatchService extends Service implements ServiceContract
{

    private $qualify;

    private $playoff;

    /**
     *
     * @param \Api\Repositories\TournamentMatchRepository $tournamentMatch
     */
    public function __construct(TournamentMatchRepository $tournamentMatch, Playoff $playoff, Qualify $qualify)
    {
        $this->repository = $tournamentMatch;
        $this->playoff = $playoff;
        $this->qualify = $qualify;
    }

    public function simulateQualify($tournament, $groups)
    {
        $this->repository->clear();
        $this->qualify->init($this->repository);

        return $this->qualify->simulate($tournament, $groups);
    }

    public function simulatePlayoff($tournament, $playoffers)
    {
        $this->playoff->init($this->repository);

        return $this->playoff->simulate($tournament, $playoffers);
    }

    public function getChampion()
    {
        return $this->playoff->getChampion();
    }

    public function getQualifyMatches()
    {
        return $this->qualify->getMatches();
    }

    public function getPlayoffMatches()
    {
        return $this->playoff->getMatches();
    }
}