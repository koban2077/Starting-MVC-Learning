<?php

namespace App\Controller;

use App\Model\User;
use App\Exception\ValidationException;
use Valitron\Validator;

class UserController
{
    private User $userModel;
    private Validator $v;

    public function __construct()
    {
        $this->userModel = new User('users');
    }

    public function index()
    {
        $users = $this->userModel->getAll();

        $data = [
            'title' => 'Users',
            'users' => $users
        ];
        return view('user.user_list', $data);
    }

    public function registration()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $data = [
                'title' => 'User registration',
            ];
            return view('user.user_registration', $data);
        }


        $data = $_POST;
        $v = new Validator($data);
        $v->rule('required', ['name', 'email', 'password']);
        $v->rule('email', 'email');
        if (!$v->validate()) {
            throw new ValidationException('validation error', $v->errors());
        }
        $this->userModel->create(
            [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password']
            ]);

        header('Location: /user');
        exit;
    }

    public function delete(): void
    {
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $this->userModel->remove($id);
        }
        header('Location: /user');
        exit;
    }

}
