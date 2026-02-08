<?php

function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function redirectIfNotLoggedIn()
{
    if (!isLoggedIn()) {
        header('Location: ' . BASE_URL . 'users/login');
        exit();
    }
}

function isAdmin()
{
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin';
}

function flash($name = '', $message = '', $class = 'alert alert-info')
{
    if (!empty($name)) {
        if (!empty($message) && empty($_SESSION[$name])) {
            if (!empty($_SESSION[$name])) {
                unset($_SESSION[$name]);
            }
            if (!empty($_SESSION[$name . '_class'])) {
                unset($_SESSION[$name . '_class']);
            }
            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class;
        } elseif (empty($message) && !empty($_SESSION[$name])) {
            $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
            echo '<div class="' . $class . '" id="msg-flash">' . $_SESSION[$name] . '</div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name . '_class']);
        }
    }
}
