<?php

class Students extends Controller
{
    private $studentModel;

    public function __construct()
    {
        redirectIfNotLoggedIn();
        $this->studentModel = $this->model('Student');
    }

    public function index()
    {
        $students = $this->studentModel->getStudents();
        $data = [
            'title' => 'Student Management',
            'students' => $students
        ];
        $this->view('students/index', $data);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'student_id' => trim($_POST['student_id']),
                'full_name' => trim($_POST['full_name']),
                'course_strand' => trim($_POST['course_strand']),
                'year_level' => trim($_POST['year_level']),
                'student_id_err' => '',
                'full_name_err' => ''
            ];

            if (empty($data['student_id'])) {
                $data['student_id_err'] = 'Please enter student ID';
            } elseif ($this->studentModel->isDuplicateId($data['student_id'])) {
                $data['student_id_err'] = 'This Student ID is already registered';
            }

            if (empty($data['full_name'])) {
                $data['full_name_err'] = 'Please enter full name';
            }

            if (empty($data['student_id_err']) && empty($data['full_name_err'])) {
                if ($this->studentModel->addStudent($data)) {
                    flash('student_message', 'Student Added');
                    $this->redirect('students');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('students/add', $data);
            }
        } else {
            $data = [
                'student_id' => '',
                'full_name' => '',
                'course_strand' => '',
                'year_level' => '',
                'student_id_err' => '',
                'full_name_err' => ''
            ];
            $this->view('students/add', $data);
        }
    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
                'student_id' => trim($_POST['student_id']),
                'full_name' => trim($_POST['full_name']),
                'course_strand' => trim($_POST['course_strand']),
                'year_level' => trim($_POST['year_level']),
                'student_id_err' => '',
                'full_name_err' => ''
            ];

            if (empty($data['student_id'])) {
                $data['student_id_err'] = 'Please enter student ID';
            } elseif ($this->studentModel->isDuplicateId($data['student_id'], $id)) {
                $data['student_id_err'] = 'This Student ID is already taken';
            }

            if (empty($data['full_name'])) {
                $data['full_name_err'] = 'Please enter full name';
            }

            if (empty($data['student_id_err']) && empty($data['full_name_err'])) {
                if ($this->studentModel->updateStudent($data)) {
                    flash('student_message', 'Student Updated');
                    $this->redirect('students');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('students/edit', $data);
            }
        } else {
            $student = $this->studentModel->getStudentById($id);
            $data = [
                'id' => $id,
                'student_id' => $student->student_id,
                'full_name' => $student->full_name,
                'course_strand' => $student->course_strand,
                'year_level' => $student->year_level,
                'student_id_err' => '',
                'full_name_err' => ''
            ];
            $this->view('students/edit', $data);
        }
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->studentModel->deleteStudent($id)) {
                flash('student_message', 'Student Removed');
                $this->redirect('students');
            } else {
                die('Something went wrong');
            }
        } else {
            $this->redirect('students');
        }
    }
}
