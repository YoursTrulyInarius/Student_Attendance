<?php

class Attendances extends Controller
{ // Named Attendances to avoid keyword conflict if any
    private $attendanceModel;
    private $subjectModel;
    private $studentModel;

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
            'title' => 'Mark Attendance',
            'subjects' => $subjects,
            'selected_subject' => isset($_GET['subject_id']) ? $_GET['subject_id'] : '',
            'date' => isset($_GET['date']) ? $_GET['date'] : date('Y-m-d'),
            'students' => []
        ];

        if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['select_subject'])) || !empty($data['selected_subject'])) {
            $data['selected_subject'] = isset($_POST['subject_id']) ? $_POST['subject_id'] : $data['selected_subject'];
            $data['date'] = isset($_POST['date']) ? $_POST['date'] : $data['date'];
            $data['students'] = $this->subjectModel->getStudentsInSubject($data['selected_subject']);

            // Fetch existing attendance to pre-fill
            $existing = $this->attendanceModel->getAttendance($data['selected_subject'], $data['date']);
            $existing_map = [];
            foreach ($existing as $att) {
                $existing_map[$att->student_id] = $att->status;
            }
            $data['existing_attendance'] = $existing_map;
        }

        $this->view('attendance/index', $data);
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_attendance'])) {
            $subject_id = $_POST['subject_id'];
            $date = $_POST['date'];
            $statuses = $_POST['status']; // Array student_id => status

            $attendanceData = [
                'subject_id' => $subject_id,
                'date' => $date,
                'teacher_id' => $_SESSION['user_id'],
                'attendance' => []
            ];

            foreach ($statuses as $student_id => $status) {
                $attendanceData['attendance'][] = [
                    'student_id' => $student_id,
                    'status' => $status
                ];
            }

            if ($this->attendanceModel->markAttendance($attendanceData)) {
                flash('attendance_message', 'Attendance Saved Successfully');
                $this->redirect('attendances');
            } else {
                die('Something went wrong');
            }
        }
    }
}
