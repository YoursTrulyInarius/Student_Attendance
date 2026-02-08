<?php

class Subject
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getSubjects()
    {
        $this->db->query('SELECT subjects.*, users.full_name as teacher_name 
                          FROM subjects 
                          LEFT JOIN users ON subjects.teacher_id = users.id 
                          ORDER BY subjects.created_at DESC');
        return $this->db->resultSet();
    }

    public function addSubject($data)
    {
        $this->db->query('INSERT INTO subjects (subject_name, teacher_id) VALUES (:subject_name, :teacher_id)');
        $this->db->bind(':subject_name', $data['subject_name']);
        $this->db->bind(':teacher_id', $data['teacher_id']);
        return $this->db->execute();
    }

    public function getSubjectById($id)
    {
        $this->db->query('SELECT * FROM subjects WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updateSubject($data)
    {
        $this->db->query('UPDATE subjects SET subject_name = :subject_name, teacher_id = :teacher_id WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':subject_name', $data['subject_name']);
        $this->db->bind(':teacher_id', $data['teacher_id']);
        return $this->db->execute();
    }

    public function deleteSubject($id)
    {
        $this->db->query('DELETE FROM subjects WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getTotalSubjects()
    {
        $this->db->query('SELECT COUNT(*) as total FROM subjects');
        $row = $this->db->single();
        return $row->total;
    }

    public function getStudentsInSubject($subject_id)
    {
        $this->db->query('SELECT students.* FROM students 
                          JOIN subject_students ON students.id = subject_students.student_id 
                          WHERE subject_students.subject_id = :subject_id');
        $this->db->bind(':subject_id', $subject_id);
        return $this->db->resultSet();
    }

    public function addStudentToSubject($subject_id, $student_id)
    {
        $this->db->query('INSERT IGNORE INTO subject_students (subject_id, student_id) VALUES (:subject_id, :student_id)');
        $this->db->bind(':subject_id', $subject_id);
        $this->db->bind(':student_id', $student_id);
        return $this->db->execute();
    }

    public function removeStudentFromSubject($subject_id, $student_id)
    {
        $this->db->query('DELETE FROM subject_students WHERE subject_id = :subject_id AND student_id = :student_id');
        $this->db->bind(':subject_id', $subject_id);
        $this->db->bind(':student_id', $student_id);
        return $this->db->execute();
    }
}
