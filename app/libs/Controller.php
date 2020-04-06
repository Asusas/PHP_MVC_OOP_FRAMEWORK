<?php
/*
 * Base Controller
 * Loads models and views
 */
class Controller
{
    // Load model
    public function model($model)
    {
        // Require model file
        require_once '../app/models/' . $model . '.php';
        // Instantiante the model
        return new $model();
    }

    // Load view
    public function view($view, $data)
    {
// Check for view file
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            // If view doesn't exist
            die('View does not exist');
        }
    }
}
