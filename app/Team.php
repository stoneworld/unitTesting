<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name', 'size'];

    public function add($users)
    {
        $this->guardAgainstTooManyMenmbers($users);

        $method = $users instanceof User ? 'save' : 'saveMany';

        return $this->members()->$method($users);
    }
    public function members()
    {
        return $this->hasMany(User::class);
    }
    public function count()
    {
        return $this->members()->count();
    }
    public function remove($users = null)
    {
        if ($users instanceof User) {
            return $users->leaveTeam();
        }
        return $this->removeMany($users);
    }
    public function removeMany($users)
    {
        return $this->members()
            ->whereIn('id', $users->pluck('id'))
            ->update(['team_id' => null]);
    }
    public function restart()
    {
        return $this->members()->update(['team_id' => null]);
    }

    public function maximumSize()
    {
        return $this->size;
    }

    protected function guardAgainstTooManyMenmbers($users)
    {
        $newTeamCount = $this->count() + $this->extractNewUsersCount($users);
        if ($newTeamCount > $this->maximumSize()) {
            throw new \Exception;
        }
    }

    protected function extractNewUsersCount($users)
    {
        return ($users instanceof User) ? 1 : count($users);
    }
}
