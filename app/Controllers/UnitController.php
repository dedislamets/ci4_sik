<?php

namespace App\Controllers;
use App\Models\Unit;
use App\Models\Direktorat;
use Config\Services;
use App\Models\DeputiDatatable;

class UnitController extends BaseController
{
    protected $unit;
 
    function __construct()
    {
        // $this->session = service('session');

        // $this->config = config('Auth');
        // $this->auth   = service('authentication');

        // if ($this->auth->check()) 
        // {
        //     session()->set('redirect_url', current_url());
        //     return redirect('login');
        // }
        
    }

    public function index()
    {        
        $this->unit = new Unit();
	    $data['deputis'] = $this->unit->getDirektorat();

        $this->direktorat = new Direktorat();
        $data['direktorat'] = $this->direktorat->findAll();

        return view('unit/index', $data);
    }

    public function create()
    {
        $this->unit = new Unit();
        $this->unit->insert([
            'nama_unit' => $this->request->getPost('nama_unit'),
            'id_direktorat' => $this->request->getPost('id_direktorat')
        ]);

		return redirect('unit')->with('success', 'Data Added Successfully');	
    }
    public function edit($id)
    {
        $this->unit = new Unit();
        $this->unit->update($id, [
                'nama_unit' => $this->request->getPost('nama_unit'),
                'id_direktorat' => $this->request->getPost('id_direktorat')
            ]);

            return redirect('unit')->with('success', 'Data Updated Successfully');
    }

    public function delete($id)
	{
        $this->unit = new Unit();
    	$this->unit->delete($id);

    	return redirect('unit')->with('success', 'Data Deleted Successfully');
	}

    public function getUnit()
    {
        $this->unit = new Unit();
        $id = $this->request->getGet('id');
        $response = $this->unit->find($id);

        echo json_encode($response);
    }
    public function getUnitByDirektorat()
    {
        $this->unit = new Unit();
        $id = $this->request->getGet('id');
        $response = $this->unit->where("id_direktorat",$id)->get()->getResultArray();

        echo json_encode($response);
    }

}