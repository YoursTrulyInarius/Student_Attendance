<?php

class Reports extends Controller
{
    private $subjectModel;
    private $studentModel;
    private $db;

    public function __construct()
    {
        redirectIfNotLoggedIn();
        $this->attendanceModel = $this->model('Attendance');
        $this->subjectModel = $this->model('Subject');
        $this->studentModel = $this->model('Student');
    }

    public function index()
    {
        $subjects = $this->subjectModel->getSubjects();
        $data = [
            'title' => 'Attendance Reports',
            'subjects' => $subjects,
            'report_type' => 'daily',
            'date' => date('Y-m-d'),
            'subject_id' => '',
            'results' => []
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data['report_type'] = $_POST['report_type'];
            $data['date'] = $_POST['date'];
            $data['subject_id'] = $_POST['subject_id'];

            if ($data['report_type'] == 'daily') {
                $this->db = new Database();
                $sql = 'SELECT attendance.*, students.full_name, students.student_id, subjects.subject_name 
                        FROM attendance 
                        JOIN students ON attendance.student_id = students.id 
                        JOIN subjects ON attendance.subject_id = subjects.id 
                        WHERE attendance_date = :date';
                if (!empty($data['subject_id'])) {
                    $sql .= ' AND attendance.subject_id = :subject_id';
                }
                $this->db->query($sql);
                $this->db->bind(':date', $data['date']);
                if (!empty($data['subject_id'])) {
                    $this->db->bind(':subject_id', $data['subject_id']);
                }
                $data['results'] = $this->db->resultSet();
            }
        }

        $this->view('reports/index', $data);
    }
}
