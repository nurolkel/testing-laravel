<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TeamTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function a_team_has_a_name()
    {
        $team = new Team(['name' => 'Acme']);

        $this->assertEquals('Acme', $team->name);
    }

    /** @test */
    public function a_team_can_add_members()
    {
        $team = Team::factory()->create();

        $user = User::factory()->create();
        $user2 = User::factory()->create();

        $team->add($user);
        $team->add($user2);

        $this->assertEquals(2, $team->count());
    }

    /** @test */
    public function a_team_has_a_maximum_size()
    {
        $team = Team::factory()->create([
            'size' => 2,
        ]);

        $userOne = User::factory()->create();
        $userTwo = User::factory()->create();

        $team->add($userOne);
        $team->add($userTwo);

        $this->assertEquals(2, $team->count() );

        $this->expectException(Exception::class);

        $userThree = User::factory()->create();

        $team->add($userThree);
    }

    /** @test */
    public function when_adding_many_members_at_once_you_still_may_not_exceed_the_team_maximum_size()
    {
        $team = Team::factory()->create([
            'size' => 2,
        ]);

        $users = User::factory(3)->create();

        $this->expectException(Exception::class);

        $team->add($users);
    }

    /** @test */
    public function a_team_can_add_multiple_members_at_once()
    {
        $team = Team::factory()->create();

        $users = User::factory(2)->create();

        $team->add($users);

        $this->assertEquals(2, $team->count());
    }

    /** @test */
    public function a_team_can_remove_a_member()
    {
        $team = Team::factory()->create();

        $users = User::factory(2)->create();

        $team->add($users);

        $team->remove($users[0]);

        $this->assertEquals(1, $team->count());
    }

    /** @test */
    public function a_team_can_remove_more_than_one_member_at_once()
    {
        $team = Team::factory()->create([
            'size' => 3
        ]);

        $users = User::factory(3)->create();

        $team->add($users);

        $team->remove($users->slice(0,2));

        $this->assertEquals(1, $team->count());
    }

    /** @test */
    public function a_team_can_remove_all_members_at_once()
    {
        $team = Team::factory()->create();

        $users = User::factory(3)->create();

        $team->add($users);
        // My solution.
        // $team->removeMembers($users);

        $team->restart();

        $this->assertEquals(0, $team->count());
    }
}
