<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Checklist extends Model
{
    use HasFactory;

    protected $table = 'checklist';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'title', 'is_completed'];

    public function getList(){
        $query = DB::table($this->table)
            ->select($this->fillable)
            ->orderBy('checklist.id', 'desc')
            ->get();
        return $query;
    }

    public function getId($id){
        $query = DB::table($this->table)
            ->select($this->fillable)
            ->where('id', $id)
            ->first();
        return $query;
    }

    public function createChecklist(array $params){
        $query = DB::table($this->table)->insertGetId($params);
        return $query;
    }

    public function updateChecklist(array $params, $checklist_id)
    {
        $query = DB::table($this->table)
            ->where('id', $checklist_id)
            ->update($params);
        return $query;
    }

    public function deleteChecklistItem($idChecklist){
        // item akan dihapus terlebih dahulu, kemudian checklist
        DB::table('item')->where('idChecklist', $idChecklist)->delete();
        return DB::table($this->table)->delete($idChecklist);
    }
}
