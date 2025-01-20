<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role_users extends Model
{
    use HasFactory;


    public function findByUserId(int $user_id)
    {
        return Role_users::where('user_id', $user_id)->first();

    }
}
