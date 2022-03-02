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
        <title>History Pay In</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>

    <body>
        <?php
        require_once ('db.php');
        $user = $_SESSION['user'];
        $history = getHistoryPayment($user);
        $info = getInformation($user);
        $info = $info->fetch_assoc();

    ?>

        <div class="container">

            <h2>History Payment</h2>
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">User</a></li>

            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <h3 style="color: green"> <?= $info['first_name'] ?> <?= $info['last_name'] ?></h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Username</th>
                                <th scope="col">Date payment</th>
                                <th scope="col">Money</th>
                                <th scope="col">Seri</th>
                                <th scope="col">exp</th>
                            </tr>
                        </thead>
                        <?php
                    while($row = mysqli_fetch_assoc($history)) { ?>

                        <tbody>
                            <tr>
                                <td><?=$row['username'] ?></td>
                                <td><?=$row['date_create'] ?></td>
                                <td><?=$row['money'] ?></td>
                                <td><?=$row['seri'] ?></td>
                                <td><?=$row['exp'] ?></td>
                            </tr>
                        </tbody>

                        <?php } ?>

                    </table>
                    <a class="btn btn-danger top-50" href="index.php" role="button" class="col col-lg-2">Back
                        Home</a>
                </div>



                <div id="menu1" class="tab-pane fade">
                    <h3>Menu 1</h3>
                    <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat.</p>
                </div>
                <div id="menu2" class="tab-pane fade">
                    <h3>Menu 2</h3>
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium,
                        totam rem aperiam.</p>
                </div>
                <div id="menu3" class="tab-pane fade">
                    <h3>Menu 3</h3>
                    <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt
                        explicabo.
                    </p>
                </div>
            </div>
        </div>

    </body>

</html>
