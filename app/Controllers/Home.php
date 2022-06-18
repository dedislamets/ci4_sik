<?php

namespace App\Controllers;
use App\Models\Karyawan;
use App\Models\Unit;
use Myth\Auth\Config\Auth as AuthConfig;
use Myth\Auth\Entities\User;
use Myth\Auth\Models\UserModel;
use App\Models\UserDatatable;
use Config\Services;

class Home extends BaseController
{
	function __construct()
    {

        $this->config = config('Auth');
        $this->auth   = service('authentication');
        
    }
    public function index()
    {
        return view('welcome_message');
    }
    public function dashboard()
    {
    	$this->karyawan = new Karyawan();
    	$this->unit = new Unit();
	    $data['karyawan'] = $this->karyawan->getAll();
	    $data['unit'] = $this->unit->findAll();
	    // print("<pre>".print_r($data,true)."</pre>");exit();
        return view('karyawan/index', $data);
    }

    public function create()
    {
        $this->karyawan = new Karyawan();
        $this->karyawan->insert([
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'status' => $this->request->getPost('status'),
            'agama' => $this->request->getPost('agama'),
            'id_unit' => $this->request->getPost('id_unit'),
        ]);

		return redirect('dashboard')->with('success', 'Data Added Successfully');	
    }

    public function edit($id)
    {
        $this->karyawan = new Karyawan();
        $this->karyawan->update($id, [
                'name' => $this->request->getPost('name_edit'),
	            'email' => $this->request->getPost('email_edit'),
	            'phone' => $this->request->getPost('phone_edit'),
	            'address' => $this->request->getPost('address_edit'),
	            'status' => $this->request->getPost('status_edit'),
	            'agama' => $this->request->getPost('agama_edit'),
	            'id_unit' => $this->request->getPost('id_unit_edit'),
            ]);

        return redirect('dashboard')->with('success', 'Data Updated Successfully');
    }

    public function ajaxList()
    {
        $request = Services::request();
        $datatable = new UserDatatable($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');
            // print("<pre>".print_r($lists,true)."</pre>");
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->name;
                $row[] = $list->email;
                $row[] = $list->phone;
                $row[] = $list->agama;
                $row[] = $list->status;
                $row[] = $list->nama_unit;
                if(!empty(user())){ 
                	$row[] = '<button type="button" class="btn btn-primary btn-edit" data-id="'. $list->id .'" onclick="showModal(this)">Edit</button>
                          <a href="'.base_url('dashboard/delete/'.$list->id) .'" class="btn btn-danger" onclick="return confirm("Are you sure ?")">Delete</a>';
              	}else{
              		$row[] = '<button type="button" class="btn btn-warning btn-lihat" data-view="1" data-id="'. $list->id .'" onclick="showModal(this)">Lihat</button>';
              	}
                
                $data[] = $row;
            }

            $output = [
                'draw' => $request->getPost('draw'),
                'recordsTotal' => $datatable->countAll(),
                'recordsFiltered' => $datatable->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }

    public function getKaryawan()
    {
        $this->karyawan = new Karyawan();
        $id = $this->request->getGet('id');
        $response = $this->karyawan->find($id);

        echo json_encode($response);
    }

    public function delete($id)
	{
        $this->karyawan = new Karyawan();
    	$this->karyawan->delete($id);

    	return redirect('dashboard')->with('success', 'Data Deleted Successfully');
	}
}
