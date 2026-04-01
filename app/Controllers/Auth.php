<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('id_user')) {
            return redirect()->to(base_url('/'));
        }
        return view('auth/login');
    }

    public function loginProcess()
    {
        $model = new UsersModel();
        $email = $this->request->getPost('email');
        $pass  = $this->request->getPost('password');

        $user = $model->findByEmail($email);

        if ($user && password_verify($pass, $user['password'])) {
            session()->set([
                'id_user' => $user['id_user'],
                'nama'    => $user['nama'],
                'email'   => $user['email'],
                'role'    => $user['role'],
                'logged_in' => true,
            ]);

            if ($user['role'] === 'admin') {
                return redirect()->to(base_url('admin'));
            }
            return redirect()->to(base_url('/'));
        }

        return redirect()->back()->with('error', 'Email atau password salah.');
    }

    public function register()
    {
        if (session()->get('id_user')) {
            return redirect()->to(base_url('/'));
        }
        return view('auth/register');
    }

    public function registerProcess()
    {
        $model = new UsersModel();

        $rules = [
            'nama'     => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'alamat'   => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->insert([
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'pembeli',
            'alamat'   => $this->request->getPost('alamat'),
        ]);

        return redirect()->to(base_url('login'))->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}
