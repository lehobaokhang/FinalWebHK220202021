<!DOCTYPE html>
<html lang="en">

    <head>
        <title>App Approve</title>
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
    ?>

        <div class="container">

            <h2>App Approve</h2>
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">Approve</a></li>
            </ul>

            <div id="home" class="tab-pane fade in active">
                <h3>Yêu cầu duyệt app</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Tên app</th>
                            <th scope="col">Tên nhà phát triển</th>
                            <th scope="col">Xem app</th>
                            <th scope="col">Duyệt</th>
                        </tr>
                    </thead>
                    <?php
                    foreach ($app_info as $key) {
                        $info = getInfoApp($key[0]);
                    ?>
                    <tbody>
                        <tr>
                            <td><?= $info['app_name'] ?></td>
                            <td><?= $info['app_name_dev'] ?></td>
                            <td><a href="index.php?app_id=<?php echo $info['app_id'] ?>"
                                    class=" default-btn font-size-sm font-style-2 bg-color-1 mr-half my-half">Xem</span></a>
                            </td>
                            <td><a href="statistical.php?app_id_request=<?php echo $info['app_id'] ?>"
                                    class=" default-btn font-size-sm font-style-2 bg-color-1 mr-half my-half">Duyệt</span></a>
                            </td>
                        </tr>
                    </tbody>

                    <?php } ?>

                </table>
                <a class="btn btn-danger top-50" href="index.php" role="button" class="col col-lg-2">Back
                    Home</a>
            </div>
            <div id="menu3" class="tab-pane fade">
                <h3>Danh sách app</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Tên app</th>
                            <th scope="col">Tên nhà phát triển</th>
                            <th scope="col">Xem app</th>
                        </tr>
                    </thead>
                    <?php
                    $info_all = getAllInfoApp();
                    foreach ($info_all as $key) {
                    ?>
                    <tbody>
                        <tr>
                            <td><?= $key[1] ?></td>
                            <td><?= $key[3] ?></td>
                            <td><a href="index.php?app_id=<?php echo $key[0] ?>"
                                    class="default-btn font-size-sm font-style-2 bg-color-1 mr-half my-half">Xem</span></a>
                            </td>
                        </tr>
                    </tbody>

                    <?php } ?>

                </table>
                <a class="btn btn-danger top-50" href="index.php" role="button" class="col col-lg-2">Back
                    Home</a>
            </div>
        </div>
        </div>

    </body>

</html>
