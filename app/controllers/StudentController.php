<?php

// --Only the functionalities related to the Students are written in here--

require_once __DIR__ . '/../models/Student.php';
require_once __DIR__ . '/../models/Grade5Result.php';
require_once __DIR__ . '/../models/OLResult.php';
require_once __DIR__ . '/../models/ALResult.php';
require_once __DIR__ . '/../helpers/session_helper.php';
require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

class StudentController {
    private $studentModel;
    private $grade5ResultModel;
    private $olResultModel;
    private $alResultModel;

    public function __construct($pdo) {
        $this->studentModel = new Student($pdo);
        $this->grade5ResultModel = new Grade5Result($pdo);
        $this->olResultModel = new OLResult($pdo);
        $this->alResultModel = new ALResult($pdo);
    }

    // View student profile
    public function viewProfile($indexNumber) {
        $student = $this->studentModel->read($indexNumber);

        if ($student) {
            return $student;
        } else {
            return false; 
        }
    }

    // View student results by exam type
    public function viewResults($indexNumber, $examType) {
        
        $student = $this->studentModel->read($indexNumber);
    
        if (!$student) {
            return false;
        }
    
        $results = [];
    
        switch ($examType) {
            case 1:
                $results = $this->grade5ResultModel->getMarks($student['index_number']);
                break;
            case 2:
                $results = $this->olResultModel->getGrades($student['index_number']);
                break;
            case 3:
                $results = $this->alResultModel->getGrades($student['index_number']);
                break;
            default:
                return false;
        }
    
        return $results;
    }
    

    public function handleStudentSignup() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $exam = $_POST['exam'];
            $id = $_POST['id'];
            $fullName = strtoupper(trim($_POST['fullName']));
            $email = trim($_POST['email']);
            $recaptchaResponse = $_POST['g-recaptcha-response'];
    
            // Validate reCAPTCHA
            $secretKey = $_ENV['RECAPTCHA_SECRET_KEY'];
            $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}");
            $responseData = json_decode($verifyResponse);
    
            if ($responseData->success) {
                // Check if the NIC or Postal ID already exists
                if ($this->studentModel->doesIdExist($id)) {
                    header('Location: /safenets/public/student/signup?message=ID already registered');
                    exit();
                }
    
                // Proceed to create the student
                $studentCreated = $this->studentModel->create($exam, $id, $fullName, $email);
    
                if ($studentCreated) {
                    header('Location: /safenets/public/student/signup?message=Registration successful!');
                } else {
                    header('Location: /safenets/public/student/signup?message=Error during registration');
                }
                exit();
            } else {
                header('Location: /safenets/public/student/signup?message=reCAPTCHA failed');
                exit();
            }
        }
    }
}
