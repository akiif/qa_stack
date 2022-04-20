<?php
    include_once('controllers/authController.php');

    if (!isset($_SESSION['id'])) {
        $_SESSION['no-access'] = "You need to be logged in to access this page!";
        header('location: login.php');
        exit();
    }

    $ans_id = "";
    $ans_content = "";
    $edit_ans = false;
    $q_content = "";
    $q_user_id = "";
    $q_date_time = "";
    $q_id = '';

    if (isset($_GET['answer'])) {    
        $q_id = $_GET['answer'];
        $query = "SELECT * FROM questions WHERE q_id=$q_id LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $question = $result->fetch_assoc();
        $q_content = $question['content'];
        $q_user_id = $question['user_id'];
        $q_date_time = $question['date_time'];
    }

    $sql = "SELECT * FROM answers WHERE q_id=$q_id ORDER BY date_time DESC";
    $ans_result = mysqli_query($conn, $sql);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['submit-ans'])) {
                $ans_content = htmlentities($_POST['ans_content']);
                $q_id = $_POST['q_id'];
                $user_id = $_SESSION['id'];
                $currentDateTime = date('Y-m-d H:i:s');
                

                if (empty($ans_content)) {
                    $errors['ans-content'] = "Please don't leave the answer field blank!";
                }

                if (count($errors) === 0) {
                    $sql = "INSERT INTO answers (ans_content, q_id, user_id, date_time) VALUES ('$ans_content', '$q_id', '$user_id', '$currentDateTime')";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    header("location: answers.php?answer=$q_id");
                    exit();
                } else {
                    header("location: answers.php?answer=$q_id");
                    exit();
                }
        }
    }

    if (isset($_GET['del-ans'])) {
        $del_id = $_GET['del-ans'];
        mysqli_query($conn, "DELETE FROM answers WHERE ans_id=$del_id");
        $_SESSION['message'] = "Address deleted!"; 
        header("location: answers.php?answer=$q_id");
    }

    if (isset($_GET['del-que'])) {
        $del_id = $_GET['del-que'];
        mysqli_query($conn, "DELETE FROM questions WHERE q_id=$del_id");
        $_SESSION['message'] = "Address deleted!"; 
        header("location: index.php");
    }

    if (isset($_GET['edit-ans'])) {
        $ans_id = $_GET['edit-ans'];
        $edit_ans = true;
        $rec = mysqli_query($conn, "SELECT * FROM answers WHERE ans_id=$ans_id");
        $record = mysqli_fetch_array($rec);
        $ans_content = $record['ans_content'];
    }

    if (isset($_POST['edit-answer'])) {
        $ans_content = mysqli_real_escape_string($conn, $_POST['ans_content']);
        echo $ans_content;
        $ans_id = mysqli_real_escape_string($conn, $_POST['ans_id']);
        $q_id = mysqli_real_escape_string($conn, $_POST['q_id']);
        mysqli_query($conn, "UPDATE answers SET ans_content='$ans_content' WHERE ans_id='$ans_id'");

        $_SESSION['msg'] = "Answer Updated!";
        header("location: answers.php?answer=$q_id");

    }
?>


<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Answers</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://kit.fontawesome.com/3316384b3d.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="css/styles.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </head>

    <body>
    
        <nav class="navbar navbar-dark bg-dark">
                <div class="container-fluid">
                    
                    <a class="navbar-brand" href="index.php">
                    <img src="images/logo.png" alt="" width="30" height="24" class="d-inline-block align-text-top">
                        QA_Stack
                    </a>
                    <li class="nav-item"><a href="index.php">Home</a>  </li>
                    <li>  <a class="" href="profile.php"><i class="fas fa-user-circle fa-1x"> Profile</i>  </a>  </li>
                    <li><a class="" href="index.php?logout=1"><i class="fas fa-sign-out-alt fa-1x"> Logout</i>  </a></li>
                </div>
            </nav>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert <?php echo $_SESSION['alert-class']; ?> alert-dismissible fade show" role="alert">
                <?php 
                    echo $_SESSION['message']; 
                    unset($_SESSION['message']);
                    unset($_SESSION['alert-class']);   
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <div class="container q-answers-table">
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th scope="col"> <h4>Question:</h4></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="card " style="width: 100%;">
                                <div class="card-body">
                                    <?php
                                        $int_user_id = (int) $q_user_id;
                                        if ($_SESSION['id'] === $int_user_id ):
                                    ?>
                                    <div class="btnn-group">
                                        <a href="answers.php?answer=<?php echo $q_id ?>&del-que=<?php echo $q_id; ?>">
                                            <button class="button" id="del_button" style="float: right; font-size:15px">Delete</button>
                                        </a>
                                    <?php endif ?>
                                    <h5 class="card-title">
                                        <?php echo $q_content; ?>
                                    </h5>
                                    <h6 class="card-subtitle mb-2 text-muted"></h6>
                                    <p class="card-text" style="text-align:right;">
                                        <?php
                                            $user_id =  $q_user_id;
                                            $query = "SELECT username FROM users WHERE user_id='$user_id' LIMIT 1";
                                            $stmt = $conn->prepare($query);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            $user = $result->fetch_assoc();
                                            echo $user['username'];
                                        ?>
                                        asked on 
                                        <?php echo $q_date_time; ?> </li>
                                    </p>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="container q-answers-table">
            <table class="table table">
                <thead>
                    <tr>
                        <th scope="col"> <h4>Answers:</h4></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($ans_result)) { ?>
                    <tr>
                        <td>
                            <div class="card " style="width: 100%;">
                                <div class="card-body">
                                    <?php
                                        $int_user_id = (int) $user_id;
                                        if ($_SESSION['id'] === $int_user_id ):
                                    ?>
                                    <div class="btnn-group">
                                        <a href="answers.php?answer=<?php echo $q_id ?>&edit-ans=<?php echo $row['ans_id']; ?>">
                                            <button class="button" id="edit_button" style="float: right; font-size:15px">Edit</button>
                                        </a>
                                        <a href="answers.php?answer=<?php echo $q_id ?>&del-ans=<?php echo $row['ans_id']; ?>">
                                            <button class="button" id="del_button" style="float: right; font-size:15px">Delete</button>
                                        </a>
                                    <?php endif ?>
                            </div>
                                    <h5 class="card-title">
                                        <?php echo $row['ans_content']; ?>
                                    </h5>
                                    <h6 class="card-subtitle mb-2 text-muted"></h6>
                                    <div class="post-info">
                                        <i class="fa-regular fa-thumbs-up like-btn" data-id="<?php echo $post['id'] ?>"></i>
                                        <span class="likes"><?php echo $row['likes']; ?></span>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="fa-regular fa-thumbs-down dislike-btn" data-id="<?php echo $post['id'] ?>"></i>
                                        <span class="dislikes"><?php echo $row['dislikes']; ?></span>
                                    </div>
                                    <p class="card-text" style="text-align:right;clear:both">
                                        <?php
                                            $user_id =  $row['user_id'];
                                            $query = "SELECT username FROM users WHERE user_id='$user_id' LIMIT 1";
                                            $stmt = $conn->prepare($query);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            $user = $result->fetch_assoc();
                                            echo $user['username'];
                                        ?>
                                        answered on 
                                        <?php echo $row['date_time']; ?> </li>
                                    </p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="container" style="padding-bottom: 20px;">
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                <?php if (count($errors) > 0): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php foreach($errors as $error): ?>

                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <input type="hidden" name="q_id" value="<?php echo $q_id; ?>">
                <div class="form-group">
                    <label for="answered"></label>
                    <textarea class="form-control" id="answered" name="ans_content" rows="4"><?php echo $ans_content; ?> </textarea>
                </div>
                <div class="form-group d-grid gap-2 d-md-flex justify-content-md-end">
                    <?php if ($edit_ans == false):?>
                        <button class="btn btn-primary" style="margin-top:10px;" type="submit" name="submit-ans">Answer</button>
                    <?php else: ?>
                        <input type="hidden" name="ans_id" value="<?php echo $ans_id; ?>">
                        <button class="btn btn-primary" style="margin-top:10px;" type="submit" name="edit-answer">Edit Answer</button>
                    <?php endif ?>
                </div>
            </form>            
        </div>
    </body>
    <footer class="text-center text-white" style="background-color: #f1f1f1; bottom:0; bottom:0;width:100%;">
    <!-- Grid container -->
        <div class="container pt-4">
            <!-- Section: Social media -->
            <section class="mb-4">

            <!-- Twitter -->
            <a
                class="btn btn-link btn-floating btn-lg text-dark m-1"
                href="https://twitter.com/zodyto"
                role="button"
                data-mdb-ripple-color="dark"
                ><i class="fab fa-twitter"></i
            ></a>

            <!-- Instagram -->
            <a
                class="btn btn-link btn-floating btn-lg text-dark m-1"
                href="https://www.instagram.com/zodyto/"
                role="button"
                data-mdb-ripple-color="dark"
                ><i class="fab fa-instagram"></i
            ></a>

            <!-- Linkedin -->
            <a
                class="btn btn-link btn-floating btn-lg text-dark m-1"
                href="https://www.linkedin.com/in/akif-mohammed/"
                role="button"
                data-mdb-ripple-color="dark"
                ><i class="fab fa-linkedin"></i
            ></a>
            <!-- Github -->
            <a
                class="btn btn-link btn-floating btn-lg text-dark m-1"
                href="https://github.com/akiif"
                role="button"
                data-mdb-ripple-color="dark"
                ><i class="fab fa-github"></i
            ></a>
            </section>
            <!-- Section: Social media -->
        </div>
    <!-- Grid container -->

    <!-- Copyright -->
        <div class="text-center text-dark p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2022 Copyright:
            <a class="text-dark" href="index.php">QA_stack.com</a>
        </div>
    <!-- Copyright -->
    </footer>
</html>