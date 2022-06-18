<?php

namespace App\Models;

use CodeIgniter\Model;

class Unit extends Model
{
    protected $table                = 'unit';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $allowedFields        = ['nama_unit','id_direktorat'];

    public function __construct()
    {
        parent::__construct();
        $this->db = db_connect();

    }
    public function getDirektorat()
    {
         return $this->db->table('unit')
         ->select("unit.*,nama_direktorat")
         ->join("direktorat","unit.id_direktorat=direktorat.id","LEFT")
         ->get()->getResultArray(); 
    }
}
