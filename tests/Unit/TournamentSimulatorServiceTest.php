<?php

namespace Tests\Unit\App;

use Tests\Unit\UnitTestCase;

class TournamentSimulatorServiceTest extends UnitTestCase
{

    public function setUp() : void
    {
        parent::setUp();

        // $this->otherDependencies = [
        //     '' => $this->mockClass(\Illuminate\Http\Request::class),
        // ];

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

        $this->dependencies['teamService']
            ->shouldReceive('createTeams')
            ->once()
            ->with($numberOfTeams)
            ->andReturn($teams['qualify']);

        $this->dependencies['groupService']
            ->shouldReceive('createGroups')
            ->once()
            ->with($tournament, $teams['qualify'])
            ->andReturn($groups)
            ->shouldReceive('teamsInPlayoffs')
            ->once()
            ->with($tournament, $matches)
            ->andReturn($teams['playoff']);

        $response = $this->testedClass->simulate(1);

        $this->assertArrayHasKey('teams', $response);
        $this->assertArrayHasKey('groups', $response);
        $this->assertArrayHasKey('matches', $response);
        $this->assertArrayHasKey('champion', $response);
    }

    public function testIndex()
    {
        $this->dependencies['service']
            ->shouldReceive('init')
            ->once()
            ->with($this->otherDependencies['request'])
            ->andReturnSelf()
            ->shouldReceive('index')
            ->once()
            ->with()
            ->andReturn($this->otherDependencies['shoesResource']);

        $return = $this->testedClass->index($this->otherDependencies['request']);

        $this->assertEquals($return, $this->otherDependencies['shoesResource']);
    }

    public function testStore()
    {
        $this->dependencies['service']
            ->shouldReceive('init')
            ->once()
            ->with($this->otherDependencies['request'])
            ->andReturnSelf()
            ->shouldReceive('store')
            ->once()
            ->with()
            ->andReturn($this->otherDependencies['shoesResource']);

        $return = $this->testedClass->store($this->otherDependencies['request']);

        $this->assertEquals($return, $this->otherDependencies['shoesResource']);
    }

    public function testShow()
    {
        $this->dependencies['service']
            ->shouldReceive('get')
            ->once()
            ->with(1)
            ->andReturn($this->otherDependencies['shoesResource']);

        $return = $this->testedClass->show(1);

        $this->assertEquals($return, $this->otherDependencies['shoesResource']);
    }

    public function testUpdate()
    {
        $this->dependencies['service']
            ->shouldReceive('init')
            ->once()
            ->with($this->otherDependencies['request'])
            ->andReturnSelf()
            ->shouldReceive('update')
            ->once()
            ->with(1)
            ->andReturn($this->otherDependencies['shoesResource']);

        $return = $this->testedClass->update($this->otherDependencies['request'], 1);

        $this->assertEquals($return, $this->otherDependencies['shoesResource']);
    }

    public function testDestroy()
    {
        $this->dependencies['service']
            ->shouldReceive('destroy')
            ->once()
            ->with(1)
            ->andReturnNull();

        $return = $this->testedClass->destroy(1);

        $this->assertNull($return);
    }
}