<?php

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function login($username, $password)
    {
        $this->db->query('SELECT users.*, roles.role_name FROM users 
                          JOIN roles ON users.role_id = roles.id 
                          WHERE username = :username');
        $this->db->bind(':username', $username);

        $row = $this->db->single();

        if ($row) {
            $hashed_password = $row->password;
            if (password_verify($password, $hashed_password)) {
                return $row;
            }
        }
        return false;
    }

    public function findUserById($id)
    {
        $this->db->query('SELECT users.*, roles.role_name FROM users 
                          JOIN roles ON users.role_id = roles.id 
                          WHERE users.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getTotalTeachers()
    {
        $this->db->query('SELECT COUNT(*) as total FROM users JOIN roles ON users.role_id = roles.id WHERE roles.role_name = "Teacher"');
        $row = $this->db->single();
        return $row->total;
    }
}
