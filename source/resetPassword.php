<?php
require_once("db.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>

<body class="body">
    <?php

    $error = [];
    $email = '';
    $pass = '';
    $pass_confirm = '';
    $message = '';

    $display_email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);

    if (isset($_GET['email']) && isset($_GET['token'])) {
        $email = $_GET['email'];
        $token = $_GET['token'];

        if (filter_var($email, FILTER_SANITIZE_EMAIL) === false) {
            $error['name'] = 'This email not valid!';
        } else if (strlen($token) != 32) {
            $error['pass_confirm'] = 'This token not valid!';
        } else {

            if (isset($_POST['pass']) && isset($_POST['pass_confirm'])) {

                $pass = $_POST['pass'];
                $pass_confirm = $_POST['pass_confirm'];

                if (empty($pass)) {
                    $error['pass'] = 'Please enter your password!';
                } else if (strlen($pass) < 6) {
                    $error['pass'] = 'Password must have at least 6 characters!';
                } else if ($pass != $pass_confirm) {
                    $error['pass_confirm'] = 'Password does not match!';
                } else {
                    $result = update_new_password($email, $pass);
                    if ($result['code'] == 0) {
                        echo "<script>
                            alert('Reset password successfully!');
                            window.location = 'logIn.php';
                        </script>";
                    }
                }
            } else {
                $error['pass_confirm'] = '';
            }
        }
    } else {
        $error['pass_confirm'] = 'Invalid email or token!!!';
    }
    ?>
    <form action="" method="post" class="form-group-signup" novalidate>
        <table>
            <tr>
                <td>
                    <h1 class="brand">Reset Password</h1>
                </td>
            </tr>

            <tr>
                <td>
                    <input value="<?= $email ?>" type="text" name="email" class="form-control" id="email" placeholder="Enter your email">
                    <span class="back-login" style="color: red"><?php echo (isset($error['email'])) ? $error['email'] : '' ?></span>
                </td>
            </tr>

            <tr>
                <td>
                    <input value="<?= $pass ?>" type="password" name="pass" class="form-control" id="pass" placeholder="Enter your password">
                    <span class="back-login" style="color: red"><?php echo (isset($error['pass'])) ? $error['pass'] : '' ?></span>
                </td>
            </tr>

            <tr>
                <td>
                    <input value="<?= $pass_confirm ?>" type="password" name="pass_confirm" class="form-control" id="pass_confirm" placeholder="Confirm your password">
                    <span class="back-login" style="color: red"><?php echo (isset($error['pass_confirm'])) ? $error['pass_confirm'] : '' ?></span>
                </td>
            </tr>

            <tr>
                <td>
                    <button type="submit" class="signIn">Reset Password</button>
                </td>
            </tr>

            <tr>
                <td>
                    <span><?= $message ?></span>
                </td>
            </tr>



        </table>
    </form>
</body>

</html>