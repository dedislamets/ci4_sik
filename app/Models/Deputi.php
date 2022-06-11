<?php

namespace App\Models;

use CodeIgniter\Model;

class Deputi extends Model
{
    protected $table                = 'deputi';
    protected $primaryKey           = 'id_deputi';
    protected $useAutoIncrement     = true;
    protected $allowedFields        = ['nama_deputi','parent_id','extention'];

    public function getAll()
    {
    	$sql = "WITH RECURSIVE generation AS (
				    SELECT id_deputi,
				        nama_deputi,
				        parent_id,
				        extention,
				        1 AS level_node
				    FROM deputi
				    WHERE parent_id =0
				 
				UNION ALL
				 
				    SELECT child.id_deputi,
				        child.nama_deputi,
				        child.parent_id,
				        child.extention,
				        level_node+1 AS level_node
				    FROM deputi child
				    JOIN generation g
				      ON g.id_deputi = child.parent_id
				)
				 
				SELECT id_deputi,parent_id,nama_deputi,extention,level_node
				FROM generation order by parent_id asc;";
         return $this->db->query($sql)
         ->getResultArray(); 
    }
    public function getAllText()
    {	
    	
        $text = '';

        $satu = $this->db->table($this->table)
         		->WHERE('parent_id',0)->get()->getResultArray();

        foreach ($satu as $key => $value) {
        	$level = 1;
        	$text .= '<tr data-id="'.$value['id_deputi'] .'" data-parent="'. $value['parent_id'] .'" data-level="'. $level .'">';
        		$text .= '<td data-column="name"><a href="javascript:void(0)" data-id="'.$value['id_deputi'] .'" onclick="showModal(this);">'.$value['nama_deputi'] .'</a></td>';
        		$text .= '<td>'.$value['extention'] .'</td>';
        		$dua = $this->db->table($this->table)
         				->WHERE('parent_id', $value['id_deputi'])->get();
         		if($dua->getNumRows()>0){
	    			// print("<pre>".print_r($dua->getNumRows(),true)."</pre>");exit();
	    			$level++;
         			foreach ($dua->getResultArray() as $key2 => $value2) {
         				$text .= $this->getTree($value2, $level);
         			}
         		}
         		

         	$text .= '</tr>';
        }
        return $text;
    }

    function getTree($value, $level){
    	$text = '<tr data-id="'.$value['id_deputi'] .'" data-parent="'. $value['parent_id'] .'" data-level="'. $level .'">';
        $text .= '<td data-column="name"><a href="javascript:void(0)" data-id="'.$value['id_deputi'] .'" onclick="showModal(this);">'.$value['nama_deputi'] .'</a></td>';
        $text .= '<td>'.$value['extention'] .'</td>';
        	$tiga = $this->db->table($this->table)
         				->WHERE('parent_id', $value['id_deputi'])->get();
     		if($tiga->getNumRows()>0){
    			$level++;
     			foreach ($tiga->getResultArray() as $key2 => $value2) {
     				$text .= $this->getTree($value2, $level);
     			}
     		}

        $text .= '</tr>';
        return $text;
    }
}
