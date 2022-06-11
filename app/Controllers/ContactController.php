<?php

namespace App\Controllers;
use App\Models\Contact;
use Myth\Auth\Config\Auth as AuthConfig;
use Myth\Auth\Entities\User;
use Myth\Auth\Models\UserModel;

class ContactController extends BaseController
{
    protected $contact;
 
    function __construct()
    {
        $this->session = service('session');

        $this->config = config('Auth');
        $this->auth   = service('authentication');

        if ($this->auth->check()) 
        {
            session()->set('redirect_url', current_url());
            return redirect('login');
        }
        
    }

    public function index()
    {        
        $this->contact = new Contact();
	    $data['contacts'] = $this->contact->findAll();

        return view('contacts/index', $data);
    }

    public function create()
    {
        $this->contact = new Contact();
        $this->contact->insert([
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
        ]);

		return redirect('contact')->with('success', 'Data Added Successfully');	
    }
    public function edit($id)
    {
        $this->contact = new Contact();
        $this->contact->update($id, [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'phone' => $this->request->getPost('phone'),
                'address' => $this->request->getPost('address'),
            ]);

            return redirect('contact')->with('success', 'Data Updated Successfully');
    }

    public function delete($id)
	{
        $this->contact = new Contact();
    	$this->contact->delete($id);

    	return redirect('contact')->with('success', 'Data Deleted Successfully');
	}

    

}