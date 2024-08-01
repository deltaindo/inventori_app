<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';

class Auth extends CI_Controller
{
    /**
     * Index function that loads the form validation library,
     * sets rules for email and password validation,
     * and loads the login view if validation fails.
     */
    public function index()
    {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == false) {
            $data['tittle'] = 'Login Page';
            $this->load->view('auth/login', $data);
        } else {

            $this->_login();
        }
    }

    /**
     * Logs in a user based on their email and password.
     *
     * This function retrieves the email and password from the POST request,
     * queries the 'user' table in the database to find a matching user,
     * and checks if the provided password matches the stored password.
     * If the user is found and the password is correct, the user's data
     * is stored in the session and they are redirected to the dashboard.
     * If the user is not found or the password is incorrect, a flash message
     * is set and the user is redirected back to the login page.
     *
     * @return void
     */
    public function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            if (md5($password) === $user['password']) {
                $data = [
                    'id'        => $user['id'],
                    'email'     => $user['email'],
                    'id_kantor' => $user['id_kantor']
                ];

                $this->session->set_userdata($data);
                redirect('dashboard/report_stok_barang');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password salah!</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">User belum terdaftar.</div>');
            redirect('auth');
        }
    }

    /**
     * Logs out the user by unsetting the 'email' and 'role_id' session data,
     * setting a flash message, and redirecting to the 'auth' page.
     *
     * @return void
     */
    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">You have been logged out!</div>');
        redirect('auth');
    }

    public function akun_saya()
    {
        $data['tittle'] = 'Akun Saya | Inventori App';

        $this->kantor           = $this->session->userdata('id_kantor');
        $this->nama_kantor      = $this->db->get_where('master_kantor', ['id' => $this->kantor])->row()->nama_kantor;
        $this->nama_pengguna    = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row()->nama_lengkap;
        $data['profil']         = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('auth/akun/setting', $data);
        $this->load->view('template/footer');
    }
}
