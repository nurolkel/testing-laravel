<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'size'];

    public function add($user)
    {
        $this->guardAgainstTooManyMembers();

        $method = $user instanceof User ? 'save' : 'saveMany';

        $this->members()->$method($user);
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
        // My solution
        // return $this->members()->find($user->id)->delete();
        // updated solution where we update the model and not the class letting the model be updated.
        if ($users instanceof User)
        {
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

    // My solution to remove all members.
    // public function removeMembers()
    // {
    //   return $this->members()->delete();
    //  }

    public function restart()
    {
        return $this->members()->update(['team_id' => null]);
    }
    protected function guardAgainstTooManyMembers()
    {
        if ($this->count() >= $this->size)
        {
            throw new \Exception();
        }
    }
}
