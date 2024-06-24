<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function index()
	{
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == false) {
            $data['tittle'] ='Login Page';
            $this->load->view('auth/login', $data);
        } else {
            
            $this->_login();
            
        }
		
	}

    public function _login(){
        $email = $this->input->post('email');   
        $password = $this->input->post('password');
            
        $user = $this->db->get_where('user',['email' => $email])->row_array();
            
        if($user) {
            if(md5($password) === $user['password']){
                $data = [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'id_gudang' => $user['id_gudang']
                ];
                    
                $this->session->set_userdata($data);
                redirect('dashboard/perlengkapan_kantor');
            }else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password salah!</div>');
                redirect('auth');
            }
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">User belum terdaftar.</div>');
            redirect('auth');
        }
    }
    

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">You have been logged out!</div>');
        redirect('auth');
    }
	
}
