<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Item extends Model
{
    use HasFactory;

    protected $table = 'item';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'idChecklist', 'name', 'status'];

    public function getByChecklistId($idChecklist){
        $query = DB::table($this->table)
            ->select(
                'item.name',
                'item.status'
            )
            ->where('idChecklist', $idChecklist)
            ->get();
        return $query;
    }

    public function createItem(array $params){
        $query = DB::table($this->table)->insertGetId($params);
        return $query;
    }

    public function updateItem(array $params, $id)
    {
        $query = DB::table($this->table)
            ->where('id', $id)
            ->update($params);
        return $query;
    }

    public function deleteItem($id){
        return DB::table($this->table)->delete($id);
    }
}
