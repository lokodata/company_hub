<?php
    $errors = array();

    function push_error($error) {
        global $errors;
        array_push($errors, $error);
    }

    function reset_errors() {
        global $errors;
        $errors = array();
    }
?>