<?php
/*
 * ob_start() -> While output buffering is active no output is sent from the script (other than headers),
 * instead the output is stored in an internal buffer.
 * This method in this project is used to send attached file from the view form.
 */
ob_start();

use PHPMailer\PHPMailer\PHPMailer;

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
                'email' => trim($_POST['email']),

                // Collecting FULL file's name and storing into temporary memory
                'file' => $_FILES['file']['name'],
                'file_tmp' => $_FILES['file']['tmp_name'],

                'subject_error' => '',
                'message_error' => '',
                'email_error' => '',
            ];

            // Validate data
            if (empty($data['subject'])) {
                $data['subject_error'] = 'Please enter your subject';

            }if (empty($data['message'])) {
                $data['message_error'] = 'Please write your message';
            }

            if (empty($data['email'])) {
                $data['email_error'] = 'Your email is required';
            }

            // If there are no errors - send email

            if (empty($data['subject_error']) && empty($data['message_error']) && empty($data['email_error'])) {

                // Check if submit input is set and pressed

                if (isset($_POST['submit']) && $_POST['submit']) {

                    // Proceed operation

                    // Collecting input fields from the form
                    $subject = $data['subject'];
                    $message = $data['message'];
                    $email = $data['email'];
                    $file = $data['file'];
                    $file_tmp = $data['file_tmp'];
                    // Getting file extention from full file name
                    $file_name = basename($file);

                    $mail = new PHPMailer(true);
                    $mail->SMTPDebug = 2;
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;

                    // Localhost: set username and password (xampp->sendmail.ini configuration)
                    $mail->Username = 'my_mail@gmail.com';
                    $mail->Password = 'my-password';

                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;
                    /*
                     * setFrom() - method which points senders email
                     * It could be taken from the form input field as well
                     * For example: $sender = $data['sender'];
                     * $mail->setFrom($sender);
                     *
                     * The rewriting of the From address is done by Gmail for security reason (fight SPAM, phishing, etc.), not by PHPMailer.
                     * Gmail (and many others) doesn't allow sending messages with random From addresses.
                     *
                     * More about it: https://github.com/PHPMailer/PHPMailer/issues/1214
                     */
                    $mail->setFrom($email, $email);
                    $mail->addReplyTo($email);
                    /*
                     * addAddress() - method which points for which recipient you are sending message
                     * It could be taken from the form input field as well
                     * For example: $receiver = $data['receiver'];
                     * $mail->addAddress($receiver);
                     *
                     */
                    $mail->addAddress('my_mail@gmail.com');
                    $mail->IsHTML(true);
                    $mail->Subject = $subject;
                    $mail->Body = $message;
                    $mail->addAttachment($file_tmp, $file_name);

                    $mail->send();

                    $_SESSION['success'] = 'Your email was sent successfuly';
                    redirect('pages/contacts');
                    /*
                     * To output what is stored in the internal buffer, ob_end_flush() is used.
                     * In our case - attached file from the form.
                     */
                    ob_end_flush();

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