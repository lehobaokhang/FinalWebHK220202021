<?php
    require_once ('db.php');

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reset Password</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body class="body">
        <?php
    $error = [];
    $email = '';
    $message = '';
    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        if (empty($email)) {
            $error['email'] = 'Please enter your email!';
        }
        else if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            $error['email'] = 'This is not valid email address!';
        }
        else {
            // reset password
            resetPassword($email);
            echo "<script>
            alert('Require reset password successfully!');    
            </script>";
            $message = 'If your email exists in the database, you will receive an email containing the reset password instructions. If you havent received the email, please resend it again! ';
        }
    }
?>
        <form class="form-group-signin" action="" method="post">
            <table>
                <tr>
                    <td>
                        <h1 class="brand">Password Recovery</h1>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input value="<?= $email ?>" type="text" name="email" class="form-control" id="email"
                            placeholder="Please enter your email">
                        <span class="back-login"
                            style="color: red"><?php echo (isset($error['email']))?$error['email']:'' ?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button class="continue" type="submit">Continue</button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="back-login"><?=$message?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a class="back-login" href="logIn.php" style="text-decoration:none">Or back to login</a>
                    </td>
                </tr>
            </table>
        </form>
    </body>
    <script src="main.js"></script>

</html>
