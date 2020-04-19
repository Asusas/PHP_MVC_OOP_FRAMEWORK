<?php

class Users extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function register()
    {
        // Check for POST request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form

            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Initialize data
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'repeat_password' => trim($_POST['repeat_password']),

                'name_error' => '',
                'email_error' => '',
                'password_error' => '',
                'confirm_password_error' => '',
            ];

            // Validate email
            if (empty($data['email'])) {
                $data['email_error'] = 'Please enter email';
            } else {
                // Check for duplicate email
                if ($this->userModel->findUseryEmail($data['email'])) {
                    $data['email_error'] = 'This email already exists';
                }
            }
            // Validate name
            if (empty($data['name'])) {
                $data['name_error'] = 'Please enter name';
            }

            // Validate password
            if (empty($data['password'])) {
                $data['password_error'] = 'Please enter password';
            } elseif (strlen($data['password']) < 5) {
                $data['password_error'] = 'Password must be at least 6 characters';
            }

            // Validate confirm password
            if (empty($data['repeat_password'])) {
                $data['confirm_password_error'] = 'Please repeat password';
            } else {
                if ($data['password'] != $data['repeat_password']) {
                    $data['confirm_password_error'] = 'Passwords do not match';
                }
            }

            // Make sure errors are empty
            if (empty($data['name_error']) && empty($data['email_error']) && empty($data['password_error']) && empty($data['confirm_password_error'])) {
                // Validate

                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                // Register User
                if ($this->userModel->register($data)) {
                    $_SESSION['success'] = 'Registration successful! You can login now';
                    redirect('users/login');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('users/register', $data);
            }

        } else {
            // Initialize data
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'repeat_password' => '',

                'name_error' => '',
                'email_error' => '',
                'password_error' => '',
                'confirm_password_error' => '',
            ];

            // Load view
            $this->view('users/register', $data);
        }
    }

    public function login()
    {
        // Check for POST request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form

            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Initialize data
            $data = [

                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),

                'email_error' => '',
                'password_error' => '',

            ];

            // Validate email
            if (empty($data['email'])) {
                $data['email_error'] = 'Please enter email';
            }

            // Validate password
            if (empty($data['password'])) {
                $data['password_error'] = 'Please enter password';
            } elseif (strlen($data['password']) < 5) {
                $data['password_error'] = 'Password must be at least 6 characters';
            }

            // Check for user / email
            if ($this->userModel->findUseryEmail($data['email'])) {
                // User found
            } else {
                // User not found
                $data['email_error'] = 'No user found';
            }

            // Make sure errors are empty
            if (empty($data['email_error']) && empty($data['password_error'])) {
                // Validate
                // Check and set logged in user
                $logged_User = $this->userModel->login($data['email'], $data['password']);

                if ($logged_User) {
                    // Create session
                    $this->user_Session($logged_User);

                } else {
                    $data['password_error'] = 'Password incorrect';
                    $this->view('users/login', $data);

                }
            } else {
                // Load view with errors
                $this->view('users/login', $data);
            }

        } else {
            // Initialize data
            $data = [

                'email' => '',
                'password' => '',

                'email_error' => '',
                'password_error' => '',

            ];

            // Load view
            $this->view('users/login', $data);
        }
    }

    public function user_Session($user)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;

        $_SESSION['success'] = 'You are logged in' . " " . $_SESSION['user_name'] . " !";

        redirect('posts/index');
    }

    public function logOut()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);

        session_destroy();

        redirect('users/login');
    }

    public function isLogedIn()
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }
}
