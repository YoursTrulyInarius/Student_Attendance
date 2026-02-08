<?php

class Subjects extends Controller
{
    private $subjectModel;
    private $userModel;
    private $studentModel;
    private $db;

    public function __construct()
    {
        redirectIfNotLoggedIn();
        $this->subjectModel = $this->model('Subject');
        $this->userModel = $this->model('User');
        $this->studentModel = $this->model('Student');
    }

    public function index()
    {
        $subjects = $this->subjectModel->getSubjects();
        $data = [
            'title' => 'Subject Management',
            'subjects' => $subjects
        ];
        $this->view('subjects/index', $data);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'subject_name' => trim($_POST['subject_name']),
                'teacher_id' => trim($_POST['teacher_id']),
                'subject_name_err' => ''
            ];

            if (empty($data['subject_name'])) {
                $data['subject_name_err'] = 'Please enter subject name';
            }

            if (empty($data['subject_name_err'])) {
                if ($this->subjectModel->addSubject($data)) {
                    flash('subject_message', 'Subject Added');
                    $this->redirect('subjects');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('subjects/add', $data);
            }
        } else {
            // Need teachers for the dropdown
            $this->db = new Database();
            $this->db->query('SELECT users.id, users.full_name FROM users JOIN roles ON users.role_id = roles.id WHERE role_name = "Teacher" OR role_name = "Admin"');
            $teachers = $this->db->resultSet();

            $data = [
                'subject_name' => '',
                'teacher_id' => '',
                'teachers' => $teachers,
                'subject_name_err' => ''
            ];
            $this->view('subjects/add', $data);
        }
    }

    public function viewDetails($id)
    {
        $subject = $this->subjectModel->getSubjectById($id);
        $studentsInSubject = $this->subjectModel->getStudentsInSubject($id);
        $allStudents = $this->studentModel->getStudents();

        $data = [
            'title' => 'Subject Details',
            'subject' => $subject,
            'students' => $studentsInSubject,
            'all_students' => $allStudents
        ];
        $this->view('subjects/details', $data);
    }

    public function addStudent($subject_id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $student_id = $_POST['student_id'];
            if ($this->subjectModel->addStudentToSubject($subject_id, $student_id)) {
                flash('subject_message', 'Student added to subject');
            } else {
                flash('subject_message', 'Error adding student', 'alert alert-danger');
            }
            $this->redirect('subjects/viewDetails/' . $subject_id);
        }
    }

    public function removeStudent($subject_id, $student_id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->subjectModel->removeStudentFromSubject($subject_id, $student_id)) {
                flash('subject_message', 'Student removed from subject');
            } else {
                flash('subject_message', 'Error removing student', 'alert alert-danger');
            }
            $this->redirect('subjects/viewDetails/' . $subject_id);
        }
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->subjectModel->deleteSubject($id)) {
                flash('subject_message', 'Subject Removed');
                $this->redirect('subjects');
            } else {
                die('Something went wrong');
            }
        } else {
            $this->redirect('subjects');
        }
    }
}
