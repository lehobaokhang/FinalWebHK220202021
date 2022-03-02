<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        echo "<script>
            alert('Please log in first!');
            window.location='logIn.php'; 
        </script>";
        exit();
    }
?>



<!DOCTYPE html>
<html lang="en">

    <head>
        <link rel="stylesheet" href="style.css">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Change Password</title>
    </head>

    <body class="body">

        <?php
        require_once ('db.php');
        $user = $_SESSION['user'];
        $info = getInformation($user);
        $info = $info->fetch_assoc();
    ?>
        <?php 
    $error = [];
    $pass = '';
    $pass_confirm = '';
    if (isset($_POST['pass']) && isset($_POST['pass_confirm'])) {

        $pass = $_POST['pass'];
        $pass_confirm = $_POST['pass_confirm'];
        $user = $_SESSION['user'];
        if (empty($pass)) {
            $error['pass'] = 'Please enter your password!';
        }else if (strlen($pass) < 6) {
            $error['pass']='Password must have at least 6 characters!' ; 
        } else if ($pass!=$pass_confirm) {
            $error['pass_confirm']='Password does not match!' ; 
        } else {
            $result=change_password($user,$pass); 
            if($result['code']==0){ 
                echo "<script>
                            alert('Reset password successfully!');
                        </script>" ; 
            } 
        } 
    }
    ?>
        <form action="" method="post" class="form-group-signup" novalidate>
            <table>
                <tr>
                    <td>
                        <h1 class="brand">Change Password</h1>
                    </td>
                </tr>


                <tr>
                    <td>
                        <input type="password" name="pass" class="form-control" id="pass"
                            placeholder="Enter your password">
                        <span class="back-login"
                            style="color: red"><?php echo (isset($error['pass']))?$error['pass']:'' ?></span>
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="password" name="pass_confirm" class="form-control" id="pass_confirm"
                            placeholder="Confirm your password">
                        <span class="back-login"
                            style="color: red"><?php echo (isset($error['pass_confirm']))?$error['pass_confirm']:'' ?></span>
                    </td>
                </tr>

                <tr>
                    <td>
                        <button type="submit" class="signIn">Change Password</button>
                    </td>
                </tr>


                <tr>
                    <td class="forgot-td">
                        <a href="index.php" class="back-login" style="text-decoration:none">Or back to home</a>
                    </td>
                </tr>


            </table>
        </form>
    </body>

</html>
