<?php

namespace App\Controllers;
use App\Models\Direktorat;
use App\Models\Extention;
use Config\Services;
use App\Models\DeputiDatatable;

class ExtentionController extends BaseController
{
    protected $extention;
    protected $direktorat;
 
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
        $this->direktorat = new Direktorat();
	    $data['direktorat'] = $this->direktorat->findAll();


        return view('extention/index', $data);
    }

    public function create()
    {
        $this->extention = new Extention();
        $this->extention->insert([
            'id_unit' => $this->request->getPost('unit'),
            'extention' => $this->request->getPost('extention'),
            'keterangan' => $this->request->getPost('keterangan'),
        ]);

		return redirect('extention')->with('success', 'Data Added Successfully');	
    }
    public function edit($id)
    {
        $this->extention = new Extention();
        $this->extention->update($id, [
                'id_unit' => $this->request->getPost('unit'),
                'extention' => $this->request->getPost('extention'),
                'keterangan' => $this->request->getPost('keterangan'),
            ]);

            return redirect('extention')->with('success', 'Data Updated Successfully');
    }

    public function delete($id)
	{
        $this->extention = new Extention();
    	$this->extention->delete($id);

    	return redirect('extention')->with('success', 'Data Deleted Successfully');
	}

    public function get()
    {
        $this->extention = new Extention();
        $id = $this->request->getGet('id');
        $response = $this->extention->modal($id);

        echo json_encode($response);
    }

    public function ajaxList()
    {
        $request = Services::request();
        $datatable = new DeputiDatatable($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->nama_direktorat;
                $row[] = $list->nama_unit;
                $row[] = $list->keterangan;
                $row[] = $list->extention;
                if(!empty(user())){ 
                    $row[] = '<button type="button" class="btn btn-primary btn-edit" data-id="'. $list->id .'" onclick="showModal(this)">Edit</button>
                          <a href="'.base_url('extention/delete/'.$list->id) .'" class="btn btn-danger" onclick="return confirm("Are you sure ?")">Delete</a>';
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
    

}