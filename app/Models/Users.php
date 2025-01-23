<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Users extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ['firstname', 'lastname', 'email'];

    public function createUser(array $params){
        $query = DB::table($this->table)->insertGetId($params);
        return $query;
    }

    public function auth($email, $password)
    {
        $query = DB::table($this->table)
            ->where('email', $email)
            ->where('password', $password)
            ->first();
        return $query;
    }
}

