<?php

class Page extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {

        $data = ['title' => 'SharePosts'];
        $this->view('pages/index', $data);
    }

    public function about()
    {
        $data = ['description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry'];
        $this->view('pages/about', $data);
    }

    public function contacts()
    {
        $this->view('pages/contacts');
    }

    public function send()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'subject' => trim($_POST['subject']),
                'message' => trim($_POST['message']),

                'subject_error' => '',
                'message_error' => '',
            ];

            // Validate data
            if (empty($data['subject'])) {
                $data['subject_error'] = 'Please enter your subject';

            }if (empty($data['message'])) {
                $data['message_error'] = 'Please write your message';
            }

            // If there are no errors - send email

            if (empty($data['subject_error']) && empty($data['message_error'])) {

                // Check if submit input is set and pressed

                if (isset($_POST['submit']) && $_POST['submit']) {

                    // Proceed operation

                    mail('andreliskrug@gmail.com', $data['subject'], $data['message']);
                    $_SESSION['success'] = 'Your email was sent successfuly';
                    redirect('pages/contacts');
                }
                // Else - load view with errors
            } else {
                $this->view('pages/contacts', $data);
            }

        } else {
            $data = [
                'subject' => '',
                'message' => '',
            ];
            $this->view('pages/contacts', $data);
        }

    }
}