<?php

namespace Tests\Unit\App;

use Tests\Unit\UnitTestCase;

class TournamentSimulatorServiceTest extends UnitTestCase
{

    public function setUp() : void
    {
        parent::setUp();

        $this->otherDependencies = [
            'tournament' => $this->mockClass(\Api\Entities\Tournament::class),
        ];

        $this->dependencies = [
            'repository' => $this->mockClass(\Api\Repositories\TournamentRepository::class),
            'teamService' => $this->mockClass(\Api\Services\TournamentTeamService::class),
            'groupService' => $this->mockClass(\Api\Services\TournamentGroupService::class),
            'matchService' => $this->mockClass(\Api\Services\TournamentMatchService::class),
        ];

        $this->testedClass = new \Api\Services\TournamentService(...array_values($this->dependencies));
    }
    
    public function testSimulate()
    {
        $numberOfTeams = 6;
        $numberPerGroups = 3;

        $groups = [
            'Group 1' => [
                'team 1', 'team 2', 'team 3',
            ],
            'Group 2' => [
                'team 4', 'team 5', 'team 6',],
        ];

        $matches = [
            'qualify' => [
                'team 1 3 x 16 team 2',
                'team 1 16 x 13 team 3',
                'team 2 16 x 10 team 3',
                'team 4 3 x 16 team 5',
                'team 4 16 x 13 team 6',
                'team 5 16 x 10 team 6',
            ],
            'playoff' => [
                'Team 1 11 x 16 Team 2',
                'Team 4 10 x 16 Team 5',
                'Team 2 16 x 14 Team 5',
            ],
        ];

        $teams = [
            'qualify' => [
                'team 1', 'team 2', 'team 3', 'team 4', 'team 5', 'team 6',  
            ],
            'playoff' => [
                'team 1', 'team 2', 'team 3', 'team 4',
            ],
        ];

        $champion = 'Team 2';

        $this->otherDependencies['tournament']
            ->shouldReceive('getAttribute')
            ->with('teams')
            ->andReturn($numberOfTeams);

        $this->dependencies['repository']
            ->shouldReceive('find')
            ->with(1)
            ->andReturn($this->otherDependencies['tournament']);

        $this->dependencies['teamService']
            ->shouldReceive('createTeams')
            ->once()
            ->with($numberOfTeams)
            ->andReturn($teams['qualify'])
            ->shouldReceive('getTeamNames')
            ->once()
            ->with()
            ->andReturn($teams['qualify']);

        $this->dependencies['groupService']
            ->shouldReceive('createGroups')
            ->once()
            ->with($this->otherDependencies['tournament'], $teams['qualify'])
            ->andReturn($groups)
            ->shouldReceive('teamsInPlayoffs')
            ->once()
            ->with($this->otherDependencies['tournament'], $matches)
            ->andReturn($teams['playoff'])
            ->shouldReceive('getTeamsInPlayoff')
            ->once()
            ->with()
            ->andReturn($teams['playoff'])
            ->shouldReceive('getGroupsAndTeams')
            ->once()
            ->with()
            ->andReturn($groups);
            
        $this->dependencies['matchService']
            ->shouldReceive('simulateQualify')
            ->with($this->otherDependencies['tournament'], $groups)
            ->andReturn($matches)
            ->shouldReceive('simulatePlayoff')
            ->with($this->otherDependencies['tournament'], $teams['playoff'])
            ->andReturn($matches)
            ->shouldReceive('getQualifyMatches')
            ->with()
            ->andReturn($matches['qualify'])
            ->shouldReceive('getPlayoffMatches')
            ->with()
            ->andReturn($matches['playoff'])
            ->shouldReceive('getChampion')
            ->with()
            ->andReturn($champion);

        $response = $this->testedClass->simulate(1);

        $this->assertArrayHasKey('teams', $response);
        $this->assertArrayHasKey('groups', $response);
        $this->assertArrayHasKey('matches', $response);
        $this->assertArrayHasKey('champion', $response);

        $this->assertEquals($response['teams'], $teams);
        $this->assertEquals($response['groups'], $groups);
        $this->assertEquals($response['matches'], $matches);
        $this->assertEquals($response['champion'], $champion);
    }

}