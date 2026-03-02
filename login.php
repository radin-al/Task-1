<?php 
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login | DOST XII Event QR</title>

    <link href="assets/img/dost.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0d6efd 0%, #6dd5ed 100%);
        }
        .card {
            border-radius: 18px;
            box-shadow: 0 8px 32px 0 rgba(13,110,253,0.18);
            animation: fadeIn 0.8s;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px);}
            to { opacity: 1; transform: translateY(0);}
        }
        .btn-primary {
            background: linear-gradient(90deg, #0d6efd 60%, #6dd5ed 100%);
            border: none;
            font-weight: 600;
            transition: background 0.3s;
        }
        .btn-primary:hover {
            background: linear-gradient(90deg, #6dd5ed 0%, #0d6efd 100%);
        }
        .card-header {
            background: transparent;
            border-bottom: none;
        }
        .login-icon {
            font-size: 2.5rem;
            color: #0d6efd;
        }
        .verification-input {
            letter-spacing: 8px;
            font-size: 2rem;
            text-align: center;
            font-weight: bold;
        }
        @media (max-width: 576px) {
            .card {
                margin-top: 2rem !important;
            }
            h3 {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container py-5">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-8 col-sm-12">
                            <?php include('admin/message.php'); ?>
                            
                            <?php if(isset($_SESSION['temp_user_id']) && isset($_SESSION['temp_verification_sent'])): ?>
                            <!-- Verification Code Form -->
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header text-center">
                                    <span class="login-icon"><i class="fas fa-shield-alt"></i></span>
                                    <h3 class="font-weight-light my-3 mb-0">Two-Factor Authentication</h3>
                                    <p class="text-muted small">Enter the verification code sent to your email</p>
                                </div>
                                <div class="card-body">
                                    <form action="verify_code.php" method="POST">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="verification_code" required placeholder="Enter 6-digit code" 
                                                   class="form-control verification-input" id="verification_code" 
                                                   maxlength="6" pattern="[0-9]{6}" />
                                            <label for="verification_code">Verification Code</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button class="btn btn-primary w-100 py-2" name="verify_btn" type="submit">
                                                <i class="fas fa-check-circle"></i> Verify & Login
                                            </button>
                                        </div>
                                        <div class="text-center mt-3">
                                            <a href="resend_code.php" class="text-decoration-none small">Resend Code</a>
                                            <span class="mx-2">|</span>
                                            <a href="cancel_login.php" class="text-decoration-none small">Cancel</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <?php else: ?>
                            <!-- Regular Login Form -->
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header text-center">
                                    <span class="login-icon"><i class="fas fa-user-lock"></i></span>
                                    <h3 class="font-weight-light my-3 mb-0">Login</h3>
                                </div>
                                <div class="card-body">
                                    <form action="loginfunction.php" method="POST">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="username" required placeholder="Username" class="form-control" id="username" />
                                            <label for="username">Username</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="password" name="password" required placeholder="Password" class="form-control" id="password"/>
                                            <label for="password">Password</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button class="btn btn-primary w-100 py-2" name="login_btn" type="submit">
                                                <i class="fas fa-sign-in-alt"></i> Login
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <div class="text-center mt-3 text-white">
                                <small>&copy; <?= date('Y'); ?> DOST XII Event QR</small>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script>
        // Auto-submit when 6 digits are entered
        document.getElementById('verification_code')?.addEventListener('input', function(e) {
            if(this.value.length === 6) {
                this.form.submit();
            }
        });
    </script>
</body>
</html>
