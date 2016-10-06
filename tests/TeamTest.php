<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Team;
use App\User;

class TeamTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * @test
     */
    public function a_team_has_a_name()
    {
        $team = new Team(['name'=>'acme']);
        $this->assertEquals('acme', $team->name);
    }

    /**
     * @test
     */
    public function a_team_can_add_members()
    {
        $team = factory(Team::class)->create();
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $team->add($user);
        $team->add($user2);
        $this->assertEquals(2, $team->count());
    }

    /** @test */
    public function a_team_has_a_maximum_size()
    {
        $team = factory(Team::class)->create(['size' => 2]);
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $team->add($user);
        $team->add($user2);
        $this->assertEquals(2, $team->count());
        $this->expectException('exception');
        $user3 = factory(User::class)->create();
        $team->add($user3);
    }
    /** @test */
    public function when_adding_many_members_at_once_you_still_may_not_exceed_the_team_maximum_size()
    {
        $team = factory(Team::class)->create(['size' => 2]);
        $users = factory(User::class, 3)->create();
        $this->expectException('exception');
        $team->add($users);
    }
    /**
     * @test
     */
    public function a_team_can_remove_a_member()
    {
        $team = factory(Team::class)->create(['size' => 2]);
        $users = factory(User::class, 2)->create();
        $team->add($users);
        $team->remove($users[0]);

        $this->assertEquals(1, $team->count());
    }

    /** @test */
    public function a_team_can_remove_all_members_at_once()
    {
        $team = factory(Team::class)->create(['size' => 2]);
        $users = factory(User::class, 2)->create();
        $team->add($users);
        $team->restart();
        $this->assertEquals(0, $team->count());
    }
    /** @test */
    public function a_team_can_remove_more_than_one_member_at_once()
    {
        $team = factory(Team::class)->create(['size' => 3]);
        $users = factory(User::class, 3)->create();
        $team->add($users);
        $team->remove($users->slice(0, 2));
        $this->assertEquals(1, $team->count());
    }
}
