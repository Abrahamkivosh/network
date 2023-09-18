<?php
/**
 * To show boostrap5 success message when session as been set $_SESSION['message_success']
 * To show boostrap5 error message when session as been set $_SESSION['message_error']
 * To show boostrap5 warning message when session as been set $_SESSION['message_warning']
 * To show boostrap5 info message when session as been set $_SESSION['message_info']
 * To
 */
if (array_key_exists('message_success', $_SESSION) && $_SESSION['message_success'] != "" && $_SESSION['message_success'] != null) {
    echo '<div class="alert alert-success" role="alert">';
    echo $_SESSION['message_success'];
    echo '</div>';
    unset($_SESSION['message_success']);
    
}

if (array_key_exists('message_error', $_SESSION) && $_SESSION['message_error'] != "" && $_SESSION['message_error'] != null) {
    echo '<div class="alert alert-danger" role="alert">';
    echo $_SESSION['message_error'];
    echo '</div>';
    unset($_SESSION['message_error']);
}

if (array_key_exists('message_warning', $_SESSION) && $_SESSION['message_warning'] != "" && $_SESSION['message_warning'] != null) {
    echo '<div class="alert alert-warning" role="alert">';
    echo $_SESSION['message_warning'];
    echo '</div>';
    unset($_SESSION['message_warning']);
}

if (array_key_exists('message_info', $_SESSION) && $_SESSION['message_info'] != "" && $_SESSION['message_info'] != null) {
    echo '<div class="alert alert-info" role="alert">';
    echo $_SESSION['message_info'];
    echo '</div>';
    unset($_SESSION['message_info']);
}

if (array_key_exists('message_danger', $_SESSION) && $_SESSION['message_danger'] != "" && $_SESSION['message_danger'] != null) {
    echo '<div class="alert alert-danger" role="alert">';
    echo $_SESSION['message_danger'];
    echo '</div>';
    unset($_SESSION['message_danger']);

}

// display errors from form validation
if (array_key_exists('errors', $_SESSION) && $_SESSION['errors'] != "" && $_SESSION['errors'] != null) {
    echo '<div class="alert alert-danger" role="alert">';
    echo '<ul>';
    foreach ($_SESSION['errors'] as $error) {
        echo '<li>' . $error . '</li>';
    }
    echo '</ul>';
    echo '</div>';
    unset($_SESSION['errors']);
}