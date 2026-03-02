<?php
session_start();
include 'admin/config/dbcon.php';

if(isset($_POST['logout_btn'])) 
{
    unset($_SESSION['auth']);
    unset($_SESSION['auth_role']);
    unset($_SESSION['auth_user']);

    $_SESSION['status'] = "Logged out successfully";
    header('Location: login.php');
    exit(0);
}

if (isset($_POST['login_btn'])) {
    // Get username and password from the form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $login_query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
    $login_query_run = mysqli_query($conn, $login_query);


    if (mysqli_num_rows($login_query_run) > 0) 
    {
        foreach ($login_query_run as $data){
            $user_id = $data['id'];
            $user_name = $data['firstname']. ' ' . $data['lastname'];
            $user_role = $data['role'];
        }
        $_SESSION['auth'] = true;
        $_SESSION['auth_role'] = $user_role; 
        $_SESSION['auth_user'] = [
            'user_id' => $user_id,
            'user_name' => $user_name,
        ];


        if($_SESSION['auth_role'] == "1") {
            $_SESSION['status'] = "Welcome to Admin Dashboard";
            header('Location: admin/index.php');
            exit(0);
        }
        elseif($_SESSION['auth_role'] == "0") {
            $_SESSION['status'] = "Welcome to User Dashboard";
            header('Location: index.php');
            exit(0);
        }
    } 
    else 
    {
       $_SESSION['status'] = "Invalid Username or Password";
       header('Location: login.php');
       exit(0);
    }
}
else 
{
   $_SESSION['status'] = "Please Login First";
   header('Location: login.php');
   exit(0);
}
