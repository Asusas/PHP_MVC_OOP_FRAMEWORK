<?php
session_start();
// Flash message

// NEVEIKIA !!!

// function flash_message($name = '', $message = '', $html_class = 'alert alert-success')
// {
//     if (!empty($name)) {
//         if (!empty($message) && empty($_SESSION[$name])) {
//             if (!empty($_SESSION[$name])) {
//                 unset($_SESSION[$name]);
//             }
//             if (!empty($_SESSION[$name . '_class'])) {
//                 unset($_SESSION[$name . '_class']);
//             }
//             $_SESSION[$anme] = $message;
//             $_SESSION[$name . '_class'] = $html_class;
//         } elseif (empty($message) && !empty($_SESSION[$name])) {
//             $html_class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
//             echo '<div class="' . $html_class . '"> ' . $_SESSION[$name] . ' </div>';
//             unset($_SESSION[$anme]);
//             unset($_SESSION[$anme . '_class']);
//         }
//     }
// }

function success_message()
{
    if (isset($_SESSION["success"])) {
        $message = '<div class="alert alert-success">' . htmlentities($_SESSION["success"]) . '</div>';
        unset($_SESSION["success"]);
        return $message;
    }
}
function error_message()
{
    if (isset($_SESSION["error"])) {
        $message = '<div class="alert alert-danger">' . htmlentities($_SESSION["error"]) . '</div>';
        unset($_SESSION["error"]);
        return $message;
    }
}
