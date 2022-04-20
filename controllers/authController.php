<?php

    session_start();

    require('config/server.php');

    $errors = array();
    $username = "";
    $email = "";
    $password = "";
    $passwordConf = "";

    // if user clicked the sinup button

    if (isset($_POST['signup-btn'])){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordConf = $_POST['passwordConf'];

        if (empty($username)){
            $errors['username'] = "Username required!";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = "Email address is invalid!";
        }
        if (empty($email)){
            $errors['email'] = "Email required!";
        }

        if (empty($password)){
            $errors['password'] = "Password required!";
        }

        if ($password !== $passwordConf){
            $errors['password'] = "The two passwords do not match!";
        }
        $query = "SELECT * FROM users WHERE email=? OR username=? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $email, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $userCount = $result->num_rows;
        $stmt->close();

        if ($userCount > 0) {
            $errors['email'] = "Email or username already exists!";
        }
    

    

        if (count($errors) === 0) {
            $password = password_hash($password, PASSWORD_DEFAULT);
        

            $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sss', $username, $email, $password);
            if ($stmt->execute()) {
                // login user
                // $user_id = $conn->insert_id;
                // $_SESSION['id'] = $user_id;
                // $_SESSION['username'] = $username;
                // $_SESSION['email'] = $email;
                // set flash message
                // $_SESSION['message'] = "You are now logged in as $username";
                // $_SESSION['alert-class'] = "alert-success";
                header('location: login.php');
                exit();

            } else {
                $errors['db_error'] = "Database error: failed to register";
            }
        }
    }

    // if user clicks on login button

    if (isset($_POST['login-btn'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (empty($username)){
            $errors['username'] = "Username required!";
        }
        if (empty($password)){
            $errors['password'] = "Password required!";
        }

        if (count($errors) === 0) {
            $sql = "SELECT * FROM users WHERE email=? OR username=? LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $username, $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
        
            // if($user){
                if (password_verify($password, $user['password'])) {
                    $_SESSION['id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    // set flash message
                    $_SESSION['message'] = "You are now logged in as $username";
                    $_SESSION['alert-class'] = "alert-success";
                    header('location: index.php');
                    exit();
                } else {
                    $errors['login_fail'] = "Wrong Credentials!";
                }
            // }
        }
    }


    // logout user

    if(isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['id']);
        unset($_SESSION['username']);
        unset($_SESSION['email']);
        header('location: login.php');
        exit();
    }

    // ask a question

    if (isset($_POST['ask-btn'])) {

        $question = $_POST['question'];
        $user_id = $_SESSION['id'];
        $currentDateTime = date('Y-m-d H:i:s');

        if (empty($question)){
            $errors['question'] = "Please don't leave the question area as blank.";
        }

        if (count($errors) === 0) {
            $sql = "INSERT INTO questions (content, user_id, date_time) VALUES ('$question', '$user_id', '$currentDateTime')";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            header('location: index.php');
            exit();
        }
    }

    


?>