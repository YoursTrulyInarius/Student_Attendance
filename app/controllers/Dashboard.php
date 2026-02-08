<?php

class Dashboard extends Controller
{
    private $studentModel;
    private $subjectModel;
    private $userModel;
    private $attendanceModel;

    public function __construct()
    {
        redirectIfNotLoggedIn();
        $this->studentModel = $this->model('Student');
        $this->subjectModel = $this->model('Subject');
        $this->userModel = $this->model('User');
        $this->attendanceModel = $this->model('Attendance');
    }

    public function index()
    {
        $total_students = $this->studentModel->getTotalStudents();
        $total_subjects = $this->subjectModel->getTotalSubjects();
        $total_teachers = $this->userModel->getTotalTeachers();
        $today_present = $this->attendanceModel->getTodayPresentCount();
        $today_overview = $this->attendanceModel->getTodayOverview();

        $data = [
            'title' => 'Dashboard',
            'stats' => [
                'total_students' => $total_students,
                'total_subjects' => $total_subjects,
                'total_teachers' => $total_teachers,
                'today_present' => $today_present
            ],
            'today_overview' => $today_overview
        ];

        $this->view('dashboard/index', $data);
    }

    public function subject_attendance($subject_id)
    {
        $attendance_list = $this->attendanceModel->getSubjectAttendanceToday($subject_id);

        if (empty($attendance_list)) {
            $this->redirect('dashboard');
        }

        $data = [
            'title' => 'Attendance Details',
            'subject_name' => $attendance_list[0]->subject_name,
            'attendance_list' => $attendance_list
        ];

        $this->view('dashboard/subject_attendance', $data);
    }
}
