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
        <title>App Manager</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>

    <body>
        <?php
    require_once('db.php');
    $info = countUser();
    $user = getFullInformation();
    $app_info = getAppRequest();
    if (isset($_GET['app_id_request'])) {
        confirmApp($_GET['app_id_request']);
        echo '<script>
        alert("Duyệt app thành công");
        window.location.href="statistical.php";        
        </script>';
    }
    if (isset($_GET['app_id'])) {
        header('Location: ./info_app.php?app_id=' . $_GET['app_id']);
    }
    if (isset($_GET['app_id_update'])) {
        header('Location: ./updateAppInfo.php?app_id_update=' . $_GET['app_id_update']);
    }

    if (isset($_GET['request_id'])) {
        addRequest();
        echo '<script>
        alert("Yêu cầu duyệt app thành công");
        window.location.href="app_manager.php";        
        </script>';
    }
    ?>

        <div class="container">

            <h2>App Manager</h2>
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">App của tôi</a></li>
                <li><a data-toggle="tab" href="#menu1">Yêu cầu duyệt app</a></li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Tên app</th>
                                <th scope="col">Sửa/Update thông tin app</th>
                                <th scope="col">Xem app</th>
                            </tr>
                        </thead>
                        <?php
                    $data = getFilebyDevName($_SESSION['user']);
                    foreach ($data as $key) { ?>
                        <tbody>
                            <tr>
                                <td><?= $key[1] ?></td>
                                <td>
                                    <a href="app_manager.php?app_id_update=<?php echo $key[0] ?>"
                                        class=" default-btn font-size-sm font-style-2 bg-color-1 mr-half my-half">Sửa</span></a>
                                </td>
                                <td>
                                    <a href="app_manager.php?app_id=<?php echo $key[0] ?>"
                                        class=" default-btn font-size-sm font-style-2 bg-color-1 mr-half my-half">Xem</span></a>
                                </td>
                            </tr>
                        </tbody>
                        <?php }
                    ?>
                    </table>
                    <a class="btn btn-danger top-50" href="index.php" role="button" class="col col-lg-2">Back
                        Home</a>
                </div>
                <div id="menu1" class="tab-pane fade">
                    <h3>Yêu cầu duyệt app</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Tên ứng dụng</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <?php
                    $files = getFilebyDevName($_SESSION['user']);
                    foreach ($files as $file) :
                    ?>
                        <tr>
                            <td><?php echo $file[1]; ?></td>
                            <?php
                            if ($file[10] === 1) {
                                echo '<td>Đã được duyệt</td>';
                                echo '<td><button type="button" class="d-none stock-btn default-btn font-size-sm font-style-2 bg-color-2">Yêu cầu duyệt</button></td>';
                            } else if ($file[9] === 0) {
                                echo '<td>Chưa đủ thông tin ứng dụng</td>';
                                echo '<td><button type="button" class="d-none stock-btn default-btn font-size-sm font-style-2 bg-color-2">Yêu cầu duyệt</button></td>';
                            } else {
                                echo '<td>Được phép yêu cầu duyệt để upload</td>';
                                echo '<td><a href="app_manager.php?request_id=' . $file[0] . '" class="d-none stock-btn default-btn font-size-sm font-style-2 bg-color-1">Yêu cầu duyệt</span></a></td>';
                            }
                            ?>
                        </tr>
                        <?php endforeach; ?>

                    </table>
                    <a class="btn btn-danger top-50" href="index.php" role="button" class="col col-lg-2">Back
                        Home</a>
                </div>
            </div>
        </div>

    </body>

</html>
