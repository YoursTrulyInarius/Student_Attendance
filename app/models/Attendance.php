<?php

class Attendance
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAttendance($subject_id, $date)
    {
        $this->db->query('SELECT * FROM attendance WHERE subject_id = :subject_id AND attendance_date = :date');
        $this->db->bind(':subject_id', $subject_id);
        $this->db->bind(':date', $date);
        return $this->db->resultSet();
    }

    public function markAttendance($data)
    {
        $this->db->query('INSERT INTO attendance (student_id, subject_id, teacher_id, attendance_date, status) 
                          VALUES (:student_id, :subject_id, :teacher_id, :attendance_date, :status) 
                          ON DUPLICATE KEY UPDATE status = :status_update');

        foreach ($data['attendance'] as $item) {
            $this->db->bind(':student_id', $item['student_id']);
            $this->db->bind(':subject_id', $data['subject_id']);
            $this->db->bind(':teacher_id', $data['teacher_id']);
            $this->db->bind(':attendance_date', $data['date']);
            $this->db->bind(':status', $item['status']);
            $this->db->bind(':status_update', $item['status']);
            $this->db->execute();
        }
        return true;
    }

    public function getDailyReport($date)
    {
        $this->db->query('SELECT attendance.*, students.full_name, subjects.subject_name 
                          FROM attendance 
                          JOIN students ON attendance.student_id = students.id 
                          JOIN subjects ON attendance.subject_id = subjects.id 
                          WHERE attendance_date = :date');
        $this->db->bind(':date', $date);
        return $this->db->resultSet();
    }

    public function getStudentSummary($student_id)
    {
        $this->db->query('SELECT status, COUNT(*) as count FROM attendance 
                          WHERE student_id = :student_id 
                          GROUP BY status');
        $this->db->bind(':student_id', $student_id);
        return $this->db->resultSet();
    }

    public function getTodayPresentCount()
    {
        $this->db->query('SELECT COUNT(*) as total FROM attendance 
                          WHERE attendance_date = CURDATE() AND status = "Present"');
        $row = $this->db->single();
        return $row->total;
    }

    public function getTodayOverview()
    {
        $this->db->query('SELECT 
                            subjects.id,
                            subjects.subject_name,
                            COUNT(attendance.id) as total_attendance,
                            SUM(CASE WHEN attendance.status = "Present" THEN 1 ELSE 0 END) as present_count,
                            SUM(CASE WHEN attendance.status = "Absent" THEN 1 ELSE 0 END) as absent_count
                          FROM subjects
                          JOIN attendance ON subjects.id = attendance.subject_id
                          WHERE attendance.attendance_date = CURDATE()
                          GROUP BY subjects.id');
        return $this->db->resultSet();
    }
    public function getSubjectAttendanceToday($subject_id)
    {
        $this->db->query('SELECT 
                            students.student_id,
                            students.lrn,
                            students.full_name,
                            students.course_strand,
                            students.year_level,
                            attendance.status,
                            subjects.subject_name
                          FROM attendance 
                          JOIN students ON attendance.student_id = students.id 
                          JOIN subjects ON attendance.subject_id = subjects.id
                          WHERE attendance.subject_id = :subject_id 
                          AND attendance_date = CURDATE()
                          ORDER BY students.full_name ASC');
        $this->db->bind(':subject_id', $subject_id);
        return $this->db->resultSet();
    }
}
