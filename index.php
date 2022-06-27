<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;900&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="assets/css/app.css">
        <link rel="stylesheet" href="assets/css/index.css">

        <title>MEU Courts</title>

    </head>

    <body>
        <script src="assets/sweetAlert/sweetalert2.all.min.js"></script>
        <?php

        include 'modules/data/connectDatabase.php';

        session_start();

        error_reporting(0);

        if (isset($_SESSION["user_id"])) {
            header("Location: public/home.php");
        }

        if (isset($_POST["login"])) {
            $email = mysqli_real_escape_string($conn, $_POST["email"]);

            $password = mysqli_real_escape_string($conn, md5($_POST["password"]));

            $check_email = mysqli_query($conn, "SELECT id FROM users WHERE email='$email' AND password='$password'");

            $checkPermission = mysqli_query($conn, "SELECT is_admin FROM users WHERE email='$email' AND password='$password'");

            $rowAdmin = mysqli_fetch_assoc($checkPermission);

            if(mysqli_num_rows($check_email) > 0 && $rowAdmin['is_admin'] == 0) {

                $row = mysqli_fetch_assoc($check_email);

                $_SESSION["user_id"] = $row['id'];

                header("Location: public/home.php");

            }elseif(mysqli_num_rows($check_email) > 0 && $rowAdmin['is_admin'] == 1) {

                $row = mysqli_fetch_assoc($check_email);

                $_SESSION["user_id"] = $row['id'];

                header("Location: admin/tsilaHome.php");
            
            }elseif(mysqli_num_rows($check_email) > 0 && $rowAdmin['is_admin'] == 2){

                $row = mysqli_fetch_assoc($check_email);

                $_SESSION["user_id"] = $row['id'];

                header("Location: admin/adminHome.php");

            }else {
                echo "
                <script>
                    swal.fire({
                        title: 'Login Failed',
                        text: 'Please check your email and password.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    })
                </script>
                ";
            }
        }

        if (isset($_POST["signup"])) {
            $fname = mysqli_real_escape_string($conn, $_POST["signup_fname"]);
            $lname = mysqli_real_escape_string($conn, $_POST["signup_lname"]);
            $email = mysqli_real_escape_string($conn, $_POST["signup_email"]);
            $password = mysqli_real_escape_string($conn, md5($_POST["signup_password"]));
            $cpassword = mysqli_real_escape_string($conn, md5($_POST["signup_cpassword"]));

            $domain = explode('@',$email)[1];

            $check_email = mysqli_num_rows(mysqli_query($conn, "SELECT email FROM users WHERE email='$email'"));

            if ($password !== $cpassword) {
                echo "<script>
                        Swal.fire({
                            title: 'Signup Failed',
                            text: 'Password does not match.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        })
                    </script>";
            } else if ($check_email > 0) {
                echo "<script>
                        Swal.fire({
                            title: 'Signup Failed',
                            text: 'Email already exists.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        })
                    </script>";
            } else if($domain != 'meu.edu.lb'){
                echo "<script>
                        Swal.fire({
                            title: 'Signup Failed',
                            text: 'Please use your MEU email.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        })
                    </script>";
            } else {
                $sql = "INSERT INTO users (first_name, last_name, email, password, is_admin) VALUES ('$fname', '$lname', '$email', '$password', 0)";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    echo "<script>
                            Swal.fire({
                                title: 'Signup Successful',
                                text: 'You can now login.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(function(){
                                window.location.href = 'index.php#sign-in';
                            });

                        </script>";
                } else {
                    echo "<script>
                            Swal.fire({
                                title: 'Signup Failed',
                                text: 'Please try again.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            })
                        </script>";
                }
            }
        }

        ?>
        <div class="header">
            <h1>MEU SPORTS</h1>
        </div>
        <main>
            <div class="main-parent">
                <div class="main" id="sign-in">
                    <div class="container">
                        <div class="sign-in">
                            <div class="upper">
                                <h2>Login to your account</h2>
                                <p>Login using social networks</p>
                            </div>
                            <div class="logos">
                                <img src="assets/img/google-icon.png" alt="" class="google" />
                            </div>
                            <form action="" method="post" class="input">
                                <input type="text" name="email" value="<?php echo $_POST['email']; ?>" placeholder="Email" class="email" required/>
                                <input type="password" name="password" value="<?php echo $_POST['password']; ?>" placeholder="Password" class="password" required/>
                                <input type="submit" name="login" class="btn-sign-in" value="Sign In" />
                            </form>
                        </div>
                        <div class="sign-up">
                            <div class="sign-up-box">
                                <div class="sign-up-content">
                                    <h2>New Here?</h2>
                                    <a class="btn-sign-up" href="#sign-up">Sign Up</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main" id="sign-up">
                    <div class="container container-sign-up">
                        <div class="sign-in">
                            <div class="upper sign-up-upper">
                                <h2>Register</h2>
                            </div>
                            <form action="" method="post" class="input">
                                <div class="f-l-name">
                                    <input type="text" name="signup_fname" value="<?php echo $_POST['signup_fname']; ?>" placeholder="First Name" class="fname" required/>
                                    <input type="text" name="signup_lname" value="<?php echo $_POST['signup_lname']; ?>" placeholder="Last Name" class="lname" required/>
                                </div>
                                <input type="text" name="signup_email" value="<?php echo $_POST['signup_email']; ?>" placeholder="Email: example@meu.edu.lb" class="email" required/>
                                <input type="password" name="signup_password" value="<?php echo $_POST['signup_password']; ?>" placeholder="Password" class="password" required/>
                                <input type="password" name="signup_cpassword" value="<?php echo $_POST['signup_cpassword']; ?>" placeholder="Confirm Password" class="password" required/>
                                <input type="submit" class="btn-sign-in" name="signup" value="Sign Up" />
                            </form>
                        </div>
                        <div class="sign-up">
                            <div class="sign-up-box">
                                <div class="sign-up-content">
                                    <h2>Have an account?</h2>
                                    <a class="btn-sign-up" href="#sign-in">Sign In</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>

