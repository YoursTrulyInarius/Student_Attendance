<?php

class Users extends Controller
{
    private $userModel;
    private $db;

    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'username_err' => '',
                'password_err' => '',
            ];

            if (empty($data['username']))
                $data['username_err'] = 'Please enter username';
            if (empty($data['password']))
                $data['password_err'] = 'Please enter password';

            if (empty($data['username_err']) && empty($data['password_err'])) {
                $loggedInUser = $this->userModel->login($data['username'], $data['password']);
                if ($loggedInUser) {
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'Password incorrect or user not found';
                    $this->view('auth/login', $data);
                }
            } else {
                $this->view('auth/login', $data);
            }
        } else {
            if (isLoggedIn())
                $this->redirect('dashboard');
            $data = [
                'username' => '',
                'password' => '',
                'username_err' => '',
                'password_err' => '',
                'is_login' => true
            ];
            $this->view('auth/login', $data);
        }
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'username' => trim($_POST['username']),
                'full_name' => trim($_POST['full_name']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'username_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'is_login' => false
            ];

            if (empty($data['username']))
                $data['username_err'] = 'Please enter username';
            if (empty($data['password']))
                $data['password_err'] = 'Please enter password';
            if ($data['password'] != $data['confirm_password'])
                $data['confirm_password_err'] = 'Passwords do not match';

            if (empty($data['username_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
                $this->db = new Database();
                $this->db->query('INSERT INTO users (username, full_name, password, role_id) VALUES (:username, :full_name, :password, 2)');
                $this->db->bind(':username', $data['username']);
                $this->db->bind(':full_name', $data['full_name']);
                $this->db->bind(':password', $data['password']);

                if ($this->db->execute()) {
                    flash('login_message', 'You are registered and can log in');
                    $this->redirect('users/login');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('auth/login', $data);
            }
        } else {
            $data = [
                'username' => '',
                'full_name' => '',
                'password' => '',
                'confirm_password' => '',
                'username_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'is_login' => false
            ];
            $this->view('auth/login', $data);
        }
    }

    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->username;
        $_SESSION['full_name'] = $user->full_name;
        $_SESSION['user_role'] = $user->role_name;
        $this->redirect('dashboard');
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_role']);
        session_destroy();
        $this->redirect('users/login');
    }

    public function manage()
    {
        if (!isAdmin()) {
            $this->redirect('dashboard');
        }
        $this->db = new Database();
        $this->db->query('SELECT users.*, roles.role_name FROM users JOIN roles ON users.role_id = roles.id');
        $users = $this->db->resultSet();

        $data = [
            'title' => 'User Management',
            'users' => $users
        ];
        $this->view('users/manage', $data);
    }

    public function add()
    {
        if (!isAdmin()) {
            $this->redirect('dashboard');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'username' => trim($_POST['username']),
                'full_name' => trim($_POST['full_name']),
                'password' => trim($_POST['password']),
                'role_id' => trim($_POST['role_id']),
                'username_err' => '',
                'password_err' => ''
            ];

            if (empty($data['username']))
                $data['username_err'] = 'Username required';
            if (empty($data['password']))
                $data['password_err'] = 'Password required';

            if (empty($data['username_err']) && empty($data['password_err'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                $this->db = new Database();
                $this->db->query('INSERT INTO users (username, full_name, password, role_id) VALUES (:username, :full_name, :password, :role_id)');
                $this->db->bind(':username', $data['username']);
                $this->db->bind(':full_name', $data['full_name']);
                $this->db->bind(':password', $data['password']);
                $this->db->bind(':role_id', $data['role_id']);

                if ($this->db->execute()) {
                    flash('user_message', 'User Added');
                    $this->redirect('users/manage');
                }
            }
            $this->view('users/add', $data);
        } else {
            $this->db = new Database();
            $this->db->query('SELECT * FROM roles');
            $roles = $this->db->resultSet();
            $data = [
                'roles' => $roles,
                'username' => '',
                'full_name' => '',
                'username_err' => '',
                'password_err' => ''
            ];
            $this->view('users/add', $data);
        }
    }
}
