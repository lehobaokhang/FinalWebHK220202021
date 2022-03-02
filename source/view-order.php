<?php
session_start();
include('db.php');
$username_of_dev = $_SESSION['user'];
$info = getInformation($_SESSION['user']);
$info = $info->fetch_assoc();
if ($info['level'] != 0 && $info['level'] != 1 ||  !isset($_SESSION['user'])) header('Location: index.php');
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title>View order</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>

    <body>
        <?php
    require_once('db.php');
    $user = getFullInformation();
    if (isset($_GET['app_id'])) {
        header('Location: ./info_app.php?app_id=' . $_GET['app_id']);
    }
    ?>

        <div class="container">

            <h2>View Order</h2>
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">Đơn hàng(Đối với app có phí)</a></li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Tên app</th>
                                <th scope="col">Tên người dùng</th>
                                <th scope="col">Ngày download</th>
                                <th scope="col">Giá</th>
                            </tr>
                        </thead>
                        <?php
                    $download_info = getOrder($username_of_dev);
                    if (!empty($download_info)) {
                        foreach ($download_info as $key) { ?>
                        <tbody>
                            <tr>
                                <td><?= $key[2] ?></td>
                                <td><?= $key[1] ?></td>
                                <td><?= $key[4] ?></td>
                                <td><?= $key[5] ?></td>
                            </tr>
                        </tbody>
                        <?php }
                    }
                    ?>
                    </table>
                    <a class="btn btn-danger top-50" href="index.php" role="button" class="col col-lg-2">Back
                        Home</a>
                </div>
            </div>
        </div>

    </body>

</html>
