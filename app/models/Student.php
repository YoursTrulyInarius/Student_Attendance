<?php

class Student
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getStudents()
    {
        $this->db->query('SELECT * FROM students ORDER BY full_name ASC');
        return $this->db->resultSet();
    }

    public function addStudent($data)
    {
        $lrn = $this->generateLRN();

        $this->db->query('INSERT INTO students (student_id, lrn, full_name, course_strand, year_level) 
                          VALUES (:student_id, :lrn, :full_name, :course_strand, :year_level)');
        $this->db->bind(':student_id', $data['student_id']);
        $this->db->bind(':lrn', $lrn);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':course_strand', $data['course_strand']);
        $this->db->bind(':year_level', $data['year_level']);

        return $this->db->execute();
    }

    public function getStudentById($id)
    {
        $this->db->query('SELECT * FROM students WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updateStudent($data)
    {
        $this->db->query('UPDATE students SET student_id = :student_id, full_name = :full_name, 
                          course_strand = :course_strand, year_level = :year_level 
                          WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':student_id', $data['student_id']);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':course_strand', $data['course_strand']);
        $this->db->bind(':year_level', $data['year_level']);

        return $this->db->execute();
    }

    private function generateLRN()
    {
        // 12-digit LRN generation
        $lrn = '';
        for ($i = 0; $i < 12; $i++) {
            $lrn .= mt_rand(0, 9);
        }

        // Ensure it's unique (quick check, though mt_rand is usually enough for 12 digits)
        $this->db->query('SELECT id FROM students WHERE lrn = :lrn');
        $this->db->bind(':lrn', $lrn);
        if ($this->db->single()) {
            return $this->generateLRN();
        }

        return $lrn;
    }

    public function deleteStudent($id)
    {
        $this->db->query('DELETE FROM students WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function isDuplicateId($student_id, $exclude_id = null)
    {
        if ($exclude_id) {
            $this->db->query('SELECT id FROM students WHERE student_id = :student_id AND id != :exclude_id');
            $this->db->bind(':exclude_id', $exclude_id);
        } else {
            $this->db->query('SELECT id FROM students WHERE student_id = :student_id');
        }
        $this->db->bind(':student_id', $student_id);
        $this->db->single();

        return $this->db->rowCount() > 0;
    }

    public function getTotalStudents()
    {
        $this->db->query('SELECT COUNT(*) as total FROM students');
        $row = $this->db->single();
        return $row->total;
    }
}
