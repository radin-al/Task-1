<?php
session_start();
include 'admin/config/dbcon.php';

// Function to send verification email
function sendVerificationEmail($email, $name, $code) {
    $subject = "Login Verification Code - DOST XII Event QR";
    $message = "
    <html>
    <head>
        <title>Login Verification Code</title>
    </head>
    <body>
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 10px;'>
            <div style='text-align: center; margin-bottom: 20px;'>
                <img src='https://yourdomain.com/assets/img/dost.png' alt='DOST XII Logo' style='max-width: 100px;'>
                <h2 style='color: #0d6efd;'>DOST XII Event QR</h2>
            </div>
            
            <div style='background-color: #f8f9fa; padding: 20px; border-radius: 8px;'>
                <h3 style='color: #333; margin-top: 0;'>Hello, $name!</h3>
                <p style='font-size: 16px; color: #555;'>Your login verification code is:</p>
                
                <div style='text-align: center; margin: 30px 0;'>
                    <span style='font-size: 36px; font-weight: bold; letter-spacing: 10px; color: #0d6efd; background-color: #e7f1ff; padding: 15px 30px; border-radius: 8px; display: inline-block;'>$code</span>
                </div>
                
                <p style='font-size: 14px; color: #777;'>This code will expire in 10 minutes.</p>
                <p style='font-size: 14px; color: #777;'>If you didn't attempt to login, please ignore this email or contact support.</p>
            </div>
            
            <div style='margin-top: 20px; text-align: center; font-size: 12px; color: #999;'>
                <p>This is an automated message, please do not reply to this email.</p>
                <p>&copy; " . date('Y') . " DOST XII Event QR. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    // Set content-type header for HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: noreply@dost12eventqr.com' . "\r\n";
    
    return mail($email, $subject, $message, $headers);
}

// Handle logout
if(isset($_POST['logout_btn'])) 
{
    // Clear all session variables
    session_unset();
    session_destroy();
    
    $_SESSION['status'] = "Logged out successfully";
    header('Location: login.php');
    exit(0);
}

// Handle initial login
if (isset($_POST['login_btn'])) {
    // Get username and password from the form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // IMPORTANT: You should use password hashing! This is just for demonstration
    $login_query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
    $login_query_run = mysqli_query($conn, $login_query);

    if (mysqli_num_rows($login_query_run) > 0) 
    {
        $user_data = mysqli_fetch_assoc($login_query_run);
        
        // Generate a 6-digit verification code
        $verification_code = sprintf("%06d", mt_rand(1, 999999));
        $expires_at = date('Y-m-d H:i:s', strtotime('+10 minutes'));
        
        // Store verification code in database
        $user_id = $user_data['id'];
        $insert_query = "INSERT INTO login_verifications (user_id, verification_code, expires_at) 
                        VALUES ('$user_id', '$verification_code', '$expires_at')";
        mysqli_query($conn, $insert_query);
        
        // Send verification email
        $user_email = $user_data['email']; // Make sure you have email field in users table
        $user_name = $user_data['firstname'] . ' ' . $user_data['lastname'];
        
        if(sendVerificationEmail($user_email, $user_name, $verification_code)) {
            // Store temporary session data
            $_SESSION['temp_user_id'] = $user_id;
            $_SESSION['temp_user_data'] = $user_data;
            $_SESSION['temp_verification_sent'] = true;
            
            $_SESSION['status'] = "A verification code has been sent to your email.";
        } else {
            $_SESSION['status'] = "Failed to send verification email. Please try again.";
        }
        
        header('Location: login.php');
        exit(0);
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
    if(!isset($_SESSION['auth'])) {
        $_SESSION['status'] = "Please Login First";
        header('Location: login.php');
        exit(0);
    }
}
?>
