<?php
/* to make sure that user that access this page is lagelly here and if not redirect him */

ob_start();

session_start();



$nolang = true;

include "app/init.php";
$id99 = isset($_SESSION['id']) ? $_SESSION['id'] : $_COOKIE['id'];
updateLastLogin($id99);

seen1($id99);
if (isset($_SESSION['phase2'])) {
    $_SESSION['phase2'] = false;
}
$obj1 = new dashboardClass("weal", "hjjh");
$_SESSION['dashboard'] = true;
//////to show welcoming message if user is new
$obj1->welcomingMessage();

if (isset($_SESSION['id']) || isset($_COOKIE['id'])) {
    $page = "default";
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    }
    if ($page == "default") {


?>

        <!-- my html code -->
        <section class="dashboard">
            <!-- navbar-->
            <nav class="navbar">
                <div>
                    <a href='<?php echo $url ?>/dashboard.php'><img src="<?php echo $url ?>/app/layout/img/chat-app-icon-logo-design-template-770ca6add87165646ba67d1a36dfee4e_screen-removebg-preview.png" /></a>
                </div>
                <div>
                    <form class="form-inline my-2 my-lg-0" method="POST" action="?page=search">
                        <input required name='search' class="form-control mr-sm-2" type="search" placeholder="Search for friends" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit"> Search</button>

                    </form>
                </div>


                <div>
                    <span class="span">setting <i class="fas fa-cog"></i></span>
                    <ul class="list-unstyled">
                        <li><a href='<?php echo $url . "/dashboard.php?page=default" ?>'>Home</a></li>
                        <li><a href='<?php echo $_SERVER['PHP_SELF'] ?>?page=edit'>your profile</a></li>
                        <li> <a href='<?php echo $url ?>/logout.php'> log out</a></li>

                    </ul>
                    <?php

                    //echo "<a href='" . $url . "/logout.php'>" . lang("logout") . " </a>";

                    ?>

                </div>
            </nav>

            <!-- navbar-->

            <!--chat app design-->
            <div class="chatapp d-flex">
                <div class="chats pad">
                    <h4>chats</h4>
                    <div class="form-group">

                    </div>


                    <div class="chat-container">

                    </div>

                </div>
                <div class="messages pad">
                    <div class="header">
                        <div class="d-flex">
                            <img src="app/layout/img//images.jpg" />
                            <bold></bold>
                            <span>i</span>
                        </div>
                    </div>
                    <div class="message-body">
                        <!-- 
                        <div class='right'>
                            <span> fgfgkjlgfkfgkjgfjkgjgkjgkgjgghuguirrui</span>
                        </div>
                        <div class='right'>
                            <span> fgfgkjlgfkfgkjgfjkgjgkjgkgjgghuguirrui</span>
                        </div>
                        <div class='right'>
                            <span> fgfgkjlgfkfgkjgfjkgjgkjgkgjgghuguirrui</span>
                        </div>
                        <div class='right'>
                            <span> fgfgkjlgfkfgkjgfjkgjgkjgkgjgghuguirrui</span>
                        </div>
                        <div class='right'>
                            <span> fgfgkjlgfkfgkjgfjkgjgkjgkgjgghuguirrui</span>
                        </div>
                        <div class='right'>
                            <span> fgfgkjlgfkfgkjgfjkgjgkjgkgjgghuguirrui</span>
                        </div>
                        <div class='right'>
                            <span> fgfgkjlgfkfgkjgfjkgjgkjgkgjgghuguirrui</span>
                        </div>
                        <div class='right'>
                            <span> fgfgkjlgfkfgkjgfjkgjgkjgkgjgghuguirrui</span>
                        </div>
                        <div class='right'>
                            <span> fgfgkjlgfkfgkjgfjkgjgkjgkgjgghuguirrui</span>
                        </div>
                        <div class='right'>
                            <span> fgfgkjlgfkfgkjgfjkgjgkjgkgjgghuguirrui</span>
                        </div>
                        <div class='right'>
                            <span> fgfgkjlgfkfgkjgfjkgjgkjgkgjgghuguirrui</span>
                        </div>
                        <div class='right'>
                            <span> fgfgkjlgfkfgkjgfjkgjgkjgkgjgghuguirrui</span>
                        </div>
                        <div class='right'>
                            <span> fgfgkjlgfkfgkjgfjkgjgkjgkgjgghuguirrui</span>
                        </div>
                        <div class='right'>
                            <span> fgfgkjlgfkfgkjgfjkgjgkjgkgjgghuguirrui</span>
                        </div>
                        <div class='right'>
                            <span> fgfgkjlgfkfgkjgfjkgjgkjgkgjgghuguirrui</span>
                        </div>
                        <div class='right'>
                            <span> fgfgkjlgfkfgkjgfjkgjgkjgkgjgghuguirrui</span>
                        </div>
                        <div class='right'>
                            <span> fgfgkjlgfkfgkjgfjkgjgkjgkgjgghuguirrui</span>
                        </div>
                        <div class='left'>
                            <span> last</span>
                        </div>
    -->



                    </div>
                    <?php
                    $id = isset($_SESSION['id']) ? $_SESSION['id'] : $_COOKIE['id'];
                    if (isthereanymessages($id)) {
                    ?>
                        <div class="message-tools d-flex">

                            <div>
                                <input type="text" placeholder="write your message header" />
                            </div>
                            <i class="fas fa-thumbs-up"></i>

                        </div>
                </div>

                <div class="user pad">
                    <p> welcome man to our app </p>
                </div>
            <?php


                    } else {
                    }
            ?>
            </div>



        </section>
    <?php
    } else if ($page == 'edit') {
        $error = false;
        $obj9 = new dashboardClass("hhh", "jkh");
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $file = $_FILES['file'];
            $oldpass = $_POST['oldpass'];
            $newpass = $_POST['newpass'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            if ($obj9->areThereAnyErrors2($email, $username, $newpass)) {

                ////to check wheter user choose image or not
                if ($file['name'] == '') {
                    $obj9->addDataIfFileFieldIsEmpty($email, $username, $oldpass, $newpass);
                } else {
                    $obj9->addDataIfFileFieldIsNotEmpty($email, $username, $oldpass, $newpass, $file);
                }
            } else {
                $error = true;
            }
        }


        $editProfile = new dashboardClass("samy", "6776");
        $rowimg = isset($_COOKIE['id']) ? $editProfile->returnSpecificData('image', $_COOKIE['id']) : $editProfile->returnSpecificData('image', $_SESSION['id']);
        $email = isset($_COOKIE['id']) ? $editProfile->returnSpecificData('email', $_COOKIE['id']) : $editProfile->returnSpecificData('email', $_SESSION['id']);
        $username = isset($_COOKIE['id']) ? $editProfile->returnSpecificData('username', $_COOKIE['id']) : $editProfile->returnSpecificData('username', $_SESSION['id']);
        $rowpass = isset($_COOKIE['id']) ? $editProfile->returnSpecificData('password', $_COOKIE['id']) : $editProfile->returnSpecificData('password', $_SESSION['id']);

    ?>
        <!-- navbar-->
        <nav class="navbar">
            <div>
                <a href='<?php echo $url ?>/dashboard.php'><img src="<?php echo $url ?>/app/layout/img/chat-app-icon-logo-design-template-770ca6add87165646ba67d1a36dfee4e_screen-removebg-preview.png" /></a>
            </div>
            <div>

            </div>


            <div>
                <span class="span">setting <i class="fas fa-cog"></i></span>
                <ul class="list-unstyled">
                    <li><a href='<?php echo $url . "/dashboard.php?page=default" ?>'>Home</a></li>
                    <li><a href='<?php echo $_SERVER['PHP_SELF'] ?>?page=edit'>your profile</a></li>
                    <li> <a href='<?php echo $url ?>/logout.php'> log out</a></li>

                </ul>
                <?php

                //echo "<a href='" . $url . "/logout.php'>" . lang("logout") . " </a>";

                ?>

            </div>
        </nav>
        <section class="body py-3">
            <h4 class="text-white mb-5  text-center">edit profile</h4>
            <div class="row">
                <div class="col-md-5">
                    <div class="photo">
                        <figure>
                            <?php
                            if ($rowimg) {
                            ?>
                                <img src="app/uploads/<?php echo $rowimg  ?>" />
                            <?php
                            } else {


                            ?>
                                <img src="app/layout/img/images.jpg" />
                            <?php

                            }
                            ?>
                            <i class="fas fa-camera"></i>

                        </figure>
                    </div>
                </div>
                <div class="col-md-7">
                    <form name='edit' class="w-50 m-auto mb-3" action='<?php echo $_SERVER['PHP_SELF'] . "?page=edit" ?>' method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="exampleInputEmail1">change Email address</label>
                            <input name='email' value="<?php echo $email ?>" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">change username</label>
                            <input name='username' value="<?php echo $username ?>" type="username" class="form-control" aria-describedby="emailHelp" placeholder="Enter username">
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1"> change Password</label>
                            <input name='newpass' type="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group d-none">
                            <label for="exampleInputPassword1"> change Password</label>
                            <input name='oldpass' value='<?php echo $rowpass ?>' type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        </div>
                        <div class="form-group d-none">
                            <label for="exampleInputPassword1"> change Password</label>
                            <input type="file" name="file" class="form-file" placeholder="Password">
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    <div class="error">
                        <?php

                        if (isset($obj9) && $error) {
                            $obj9->printErrorsArray();
                        }
                        ?>
                    </div>
                </div>
            </div>
            </secton>
            <!-- navbar-->
        <?php
    } elseif ($page == 'suggest') {
        $obj131 = new dashboardClass("weal", "hjjh");
        ?>
            <!-- my html code -->
            <section class="dashboard">
                <!-- navbar-->
                <nav class="navbar">
                    <div>
                        <a href='<?php echo $url ?>/dashboard.php'><img src="<?php echo $url ?>/app/layout/img/chat-app-icon-logo-design-template-770ca6add87165646ba67d1a36dfee4e_screen-removebg-preview.png" /></a>
                    </div>
                    <div>
                        <form class="form-inline my-2 my-lg-0" method="POST" action="?page=search">
                            <input required name='search' class="form-control mr-sm-2" type="search" placeholder="Search for friends using username" aria-label="Search">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit"> Search</button>

                        </form>
                    </div>


                    <div>
                        <span class="span">setting <i class="fas fa-cog"></i></span>
                        <ul class="list-unstyled">
                            <li><a href='<?php echo $url . "/dashboard.php?page=default" ?>'>Home</a></li>
                            <li><a href='<?php echo $_SERVER['PHP_SELF'] ?>?page=edit'>your profile</a></li>
                            <li> <a href='<?php echo $url ?>/logout.php'> log out</a></li>

                        </ul>
                        <?php

                        //echo "<a href='" . $url . "/logout.php'>" . lang("logout") . " </a>";

                        ?>

                    </div>
                </nav>

                <!-- navbar-->

                <div class="results py-5">
                    <?php
                    $id = isset($_SESSION['id']) ? $_SESSION['id'] : $_COOKIE['id'];

                    $stmt =  $obj131->con()->prepare('SELECT * FROM `users` WHERE  id != ? LIMIT 5');
                    $stmt->execute(array($id));
                    $count = $stmt->rowCount();
                    $rows = $stmt->fetchAll();



                    foreach ($rows as $row) {
                        echo '<div class="mb-5" data-id="' . $row['id'] . '">';
                        if ($row['image'] == '') {
                            echo "<img src='app/uploads/images.jpg'>";
                        } else {


                            echo "<img src='app/uploads/" . $row['image'] . "'>";
                        }
                        echo '<bold>' . $row['username'] . "</bold>";
                        echo ' <button class="btn btn-danger btn-chat">chat with him and say hi</button>';
                        echo '<div class="clearfix"></div>';
                        echo " </div>";
                    }





                    ?>

                    <!--
                    <div class="mb-5">
                        username
                        <button class="btn btn-danger">chat with him and say hi</button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="mb-5">
                        username
                        <button class="btn btn-danger">chat with him and say hi</button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="mb-5">
                        username
                        <button class="btn btn-danger">chat with him and say hi</button>
                        <div class="clearfix"></div>
                    </div>
    -->
                </div>
            </section>
        <?php
    } elseif ($page == 'search') {
        $search = $_POST['search'];
        $obj141 = new dashboardClass("weal", "hjjh");
        ?>
            <!-- my html code -->
            <section class="dashboard">
                <!-- navbar-->
                <nav class="navbar">
                    <div>
                        <a href='<?php echo $url ?>/dashboard.php'><img src="<?php echo $url ?>/app/layout/img/chat-app-icon-logo-design-template-770ca6add87165646ba67d1a36dfee4e_screen-removebg-preview.png" /></a>
                    </div>
                    <div>
                        <form class="form-inline my-2 my-lg-0" method="POST" action="?page=search">
                            <input required name='search' class="form-control mr-sm-2" type="search" placeholder="Search for friends using username" aria-label="Search">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit"> Search</button>

                        </form>
                    </div>


                    <div>
                        <span class="span">setting <i class="fas fa-cog"></i></span>
                        <ul class="list-unstyled">
                            <li><a href='<?php echo $url . "/dashboard.php?page=default" ?>'>Home</a></li>
                            <li><a href='<?php echo $_SERVER['PHP_SELF'] ?>?page=edit'>your profile</a></li>
                            <li> <a href='<?php echo $url ?>/logout.php'> log out</a></li>

                        </ul>
                        <?php

                        //echo "<a href='" . $url . "/logout.php'>" . lang("logout") . " </a>";

                        ?>

                    </div>
                </nav>

                <!-- navbar-->

                <div class="results py-5">
                    <?php
                    $id = isset($_SESSION['id']) ? $_SESSION['id'] : $_COOKIE['id'];
                    $val = "%" . $search . "%";
                    $stmt =  $obj141->con()->prepare('SELECT * FROM `users` WHERE username LIKE ? AND id != ?');
                    $stmt->execute(array($val, $id));
                    $count = $stmt->rowCount();
                    $rows = $stmt->fetchAll();

                    if ($count == 0) {
                        echo "<div class='text-center'> there is no users by this name";
                    } else {

                        foreach ($rows as $row) {
                            echo '<div class="mb-5" data-id="' . $row['id'] . '">';
                            if ($row['image'] == '') {
                                echo "<img src='app/uploads/images.jpg'>";
                            } else {


                                echo "<img src='app/uploads/" . $row['image'] . "'>";
                            }
                            echo '<bold>' . $row['username'] . "</bold>";
                            echo ' <button class="btn btn-danger btn-chat">chat with him and say hi</button>';
                            echo '<div class="clearfix"></div>';
                            echo " </div>";
                        }
                    }





                    ?>

                    <!--
                    <div class="mb-5">
                        username
                        <button class="btn btn-danger">chat with him and say hi</button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="mb-5">
                        username
                        <button class="btn btn-danger">chat with him and say hi</button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="mb-5">
                        username
                        <button class="btn btn-danger">chat with him and say hi</button>
                        <div class="clearfix"></div>
                    </div>
    -->
                </div>



            </section>




    <?php

    } else {
        header("Location:" . $url . "/index.php");
        exit();
    }
    include "app/includes/views/footer.php";
} else {
    header("Location:" . $url . "/logout.php");
    exit();
}
ob_end_flush();
    ?>