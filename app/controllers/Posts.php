<?php
class Posts extends Controller
{
    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('users/login');
        }
        // Loading Post model
        $this->postModel = $this->model('Post');
        // Loading User model
        $this->userModel = $this->model('User');
    }

    public function index()
    {
        $posts = $this->postModel->getPosts();

        $data = [
            'posts' => $posts,
        ];

        $this->view('posts/index', $data);
    }

    public function addPost()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],

                'title_error' => '',
                'body_error' => '',

            ];
            // Validate data
            if (empty($data['title'])) {
                $data['title_error'] = 'Please enter title';
            }
            if (empty($data['body'])) {
                $data['body_error'] = 'Please fill in body text';
            }

            // Make sure there are no errors

            if (empty($data['title_error']) && empty($data['body_error'])) {
                // Validated
                if ($this->postModel->createPost($data)) {
                    $_SESSION['success'] = 'Post added successfuly';
                    redirect('posts/index');
                } else {
                    $this->view('posts/add');
                }
            } else {
                // Load view with errors
                $this->view('posts/add', $data);
            }

        } else {
            $data = [
                'title' => '',
                'body' => '',
            ];
            $this->view('posts/add', $data);
        }

    }

    public function showPost($id)
    {
        // Instead of making JOIN in post model - we are loading two separate post and user models (see info in __constructor above)
        $post = $this->postModel->getPostById($id);
        $user = $this->userModel->getUserById($post->user_id);

        $data = [
            'post' => $post,
            'user' => $user,
        ];
        $this->view('posts/show', $data);
    }

    public function editPost()
    {
        $data = [];
        $this->view('posts/edit', $data);
    }

    public function editPostById($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],

                'title_error' => '',
                'body_error' => '',

            ];
            // Validate data
            if (empty($data['title'])) {
                $data['title_error'] = 'Please enter title';
            }
            if (empty($data['body'])) {
                $data['body_error'] = 'Please fill in body text';
            }

            // Make sure there are no errors

            if (empty($data['title_error']) && empty($data['body_error'])) {
                // Validated
                if ($this->postModel->updatePost($data)) {
                    $_SESSION['success'] = 'Post updated successfuly';
                    redirect('posts/index');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('posts/edit', $data);
            }

        } else {
            // Get existing post from model
            $post = $this->postModel->getPostById($id);
            // Check for post owner !!! Kad niekas negaletu padaryti pakitimu per URL'a !!!
            if ($post->user_id != $_SESSION['user_id']) {
                redirect('posts/edit');
            }
            $data = [
                'id' => $id,
                'post' => $post,
            ];
            $this->view('posts/edit', $data);
        }

    }

    public function deletePost($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Get existing post from model
            $post = $this->postModel->getPostById($id);
            // Check for post owner !!! Kad niekas negaletu padaryti pakitimu per URL'a !!!
            if ($post->user_id != $_SESSION['user_id']) {
                redirect('posts/edit');
            }

            if ($this->postModel->deletePostById($id)) {
                $_SESSION['success'] = 'Post deleted successfuly';
                redirect('posts/index');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('posts/index');
        }
    }

}