<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: logIn.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <link rel="stylesheet" href="style.css">
        <title>Create Money Card</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>

    <body class="body-pro2">
        <?php
            require_once ('db.php');
            $user = $_SESSION['user'];
            $info = getInformation($user);
            $info = $info->fetch_assoc();
            $message = '';

            if(isset($_POST['submit'])) {
                $option_money = $_POST['option_money'];
                $number = $_POST['number'];

                if(empty($number)) {
                    $message = 'Please enter number need to create money card!';
                }else if($number <= 0) {
                    $message = 'Number need to create money card not valid!';
                } else {
                    $user = $_SESSION['user'];
                    
                    $result = createMoney($number, $option_money);
                    
                    if($result['code'] == 0) {
                        echo "<script>
                                alert('Create money card successfully!');
                                window.location = 'index.php';
                            </script>";
                    }
                }

            }
         ?>

        <form action="" method="post" class="form-group-signin">
            <table>
                <tr>
                    <td>
                        <h1 class="brand">Create Money Card</h1>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="hello-dev">Hello,<?= $info['first_name']?> <?= $info['last_name']?></p>

                        <p>✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽✽</p>
                        <input type="hidden" value="<?=$info['money']?>" name="money" />
                    </td>
                    <input type="hidden" value="<?=$info['money']?>" name="money" />
                    <input type="hidden" value="<?=$info['level']?>" name="level" />

                </tr>

                <tr>
                    <td>
                        <select class="selectMoney" name="option_money">
                            <option value="50000">50,000 VNĐ</option>
                            <option value="100000">100,000 VNĐ</option>
                            <option value="200000">200,000 VNĐ</option>
                            <option value="500000">500,000 VNĐ</option>
                        </select>
                    </td>

                </tr>

                <tr>
                    <td>
                        <input type="text" name="number" class="form-control" id="number"
                            placeholder="Enter number need to create money card">

                    </td>
                </tr>

                <tr>
                    <td>
                        <button type="submit" name="submit" value="Submit" class="signIn">Create</button>
                    </td>
                </tr>

                <tr>
                    <td>
                        <span class="message"><?=$message?></span>
                    </td>
                </tr>


                <tr>
                    <td>
                        <hr width="30%" align="center" />
                    </td>
                </tr>

                <tr>
                    <td>
                        <a href="index.php" class="back-login">Or back to home</a>
                    </td>
                </tr>
            </table>
        </form>

    </body>

</html>
