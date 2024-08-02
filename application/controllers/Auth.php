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

    /**
     * Retrieves the user's account information and displays it on the 'Akun Saya' page.
     *
     * @return void
     */
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

    /**
     * Updates the user account information.
     *
     * This function validates the input fields for 'nama_akun', 'nama_lengkap', and 'email_akun'.
     * If the validation fails, it sets a flash message with the validation errors and redirects to 'auth/akun_saya'.
     * If the validation succeeds, it updates the user account information in the 'user' table.
     * If the 'password_akun' field is not provided, it updates the 'Nama', 'nama_lengkap', and 'email' fields.
     * If the 'password_akun' field is provided, it updates the 'Nama', 'nama_lengkap', 'email', and 'password' fields.
     * After the update, it sets a flash message with a success message and redirects to 'auth/logout'.
     *
     * @return void
     */
    public function update_akun()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama_akun', 'Nama Akun', 'required');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('email_akun', 'Email Akun', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . validation_errors() . '</div>');
            redirect('auth/akun_saya');
        } else {
            if(!$this->input->post('password_akun')){
                $data = [
                    'Nama'          => $this->input->post('nama_akun'),
                    'nama_lengkap'  => $this->input->post('nama_lengkap'),
                    'email'         => $this->input->post('email_akun'),
                ];
                $this->db->where('id', $this->session->userdata('id'));
                $this->db->update('user', $data);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Akun Berhasil di Update</div>');
                redirect('auth/logout');
            } elseif ($this->input->post('password_akun')) {
                $data = [
                    'Nama'          => $this->input->post('nama_akun'),
                    'nama_lengkap'  => $this->input->post('nama_lengkap'),
                    'email'         => $this->input->post('email_akun'),
                    'password'      => md5($this->input->post('password_akun')),
                ];
                $this->db->where('id', $this->session->userdata('id'));
                $this->db->update('user', $data);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Akun Berhasil di Update</div>');
                redirect('auth/logout');
            }   
        }
    }
}
