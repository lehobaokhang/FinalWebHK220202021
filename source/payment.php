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
        <title>Pay in money</title>
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
                $money_option = $_POST['option_money'];
                $seri = $_POST['seri'];
                $seri_data = getFullSeri($seri);
                


                if(empty($seri_data)) {
                    $message = 'Please enter seri card money or seri not valid!';
                }else if($money_option != $seri_data['option_money']) {
                    $message = 'Please check seri code with option money you choose!';
                } 
                else if($seri_data['exp'] === 0) {
                    $message = 'Your money card expiration, please contact with admin to get some card new!';
                }else {
                    $user = $_SESSION['user'];
                    $money = $_POST['money'];
                    $result = payment($user, $money_option, $seri);

                    $resuls = updateExpCode($seri);
                    
                    if($money_option == 50000) {
                        pay_fif($user, $money);
                    } else if($money_option == 100000) {
                        pay_onehu($user, $money);
                    } else if($money_option == 200000) {
                        pay_twohu($user, $money);
                    } else if($money_option == 500000) {
                        pay_fivehu($user, $money);
                    } 
                    if($result['code'] == 0) {
                        echo "<script>
                                alert('Pay in money successfully!');
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
                        <h1 class="brand">Pay In Money</h1>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="hello-dev">Hello,<?= $info['first_name']?> <?= $info['last_name']?></p>
                        <p class="regis-devs">Account balance: <?=$info['money']?> VNĐ</p>
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
                        <input type="text" name="seri" class="form-control" id="seri" placeholder="Enter seri">

                    </td>
                </tr>

                <tr>
                    <td>
                        <button type="submit" name="submit" value="Submit" class="signIn">Get</button>
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
