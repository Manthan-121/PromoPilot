<?php
include_once ("./includes/config.php");

if(isset($_SESSION['id'])){
    header("Location: index.php");
    exit();
}
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['btn_login']) == "login"){
        $email = mysqli_real_escape_string($conn,$_POST['email']);
        $password = mysqli_real_escape_string($conn,$_POST['password']);
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            if(password_verify($password,$row['password'])){
                $_SESSION['id'] = $row['id'];
                header("Location: index.php");
                exit();
            }
            else{
                $pwdmsg = "Invalid password";
            }
        }else{
            $emailmsg = "Email not found";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>PromoPilot</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="assets/css/app.min.css">
    <link rel="stylesheet" href="assets/bundles/bootstrap-social/bootstrap-social.css">
    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/components.css">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel='shortcut icon' type='image/x-icon' href='assets/img/logo.png' />
</head>

<body>
    <div class="loader"></div>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Login</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="<?php $_SERVER["PHP_SELF"]?>" class="needs-validation" novalidate="">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" class="form-control <?php if(isset($emailmsg) != null){ echo "is-invalid";}?>" value="<?php if(isset($_POST['email'])) { echo htmlspecialchars($_POST['email']); } ?>" name="email" tabindex="1" required autofocus>
                                        <div class="invalid-feedback">
                                        <?php 
                                                if(isset($emailmsg) != null){
                                                    echo $emailmsg;
                                                }else{
                                                    echo "Please fill in your email";
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label">Password</label>
                                            <div class="float-right">
                                                <a href="#" class="text-small">
                                                    Forgot Password?
                                                </a>
                                            </div>
                                        </div>
                                        <input id="password" type="password" class="form-control <?php if(isset($pwdmsg) != null){ echo "is-invalid";}?>" name="password" tabindex="2" required>
                                        <div class="invalid-feedback">
                                            <?php 
                                                if(isset($pwdmsg) != null){
                                                    echo $pwdmsg;
                                                }else{
                                                    echo "Please fill in your password";
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                                            <label class="custom-control-label" for="remember-me">Remember Me</label>
                                        </div>
                                    </div> -->
                                    <div class="form-group">
                                        <button type="submit" value="login" name="btn_login" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            Login
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- General JS Scripts -->
    <script src="assets/js/app.min.js"></script>
    <!-- JS Libraies -->
    <!-- Page Specific JS File -->
    <!-- Template JS File -->
    <script src="assets/js/scripts.js"></script>
    <!-- Custom JS File -->
    <script src="assets/js/custom.js"></script>
</body>

</html>