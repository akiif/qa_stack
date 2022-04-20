<?php
    include_once('controllers/authController.php');

    if (!isset($_SESSION['id'])) {
        $_SESSION['no-access'] = "You need to be logged in to access this page!";
        header('location: login.php');
        exit();
    }

    $query = "SELECT * FROM questions";
    $results = mysqli_query($conn, $query);


?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Homepage</title>
        <link rel="icon" href="images/logo.png">
        <script src="https://kit.fontawesome.com/3316384b3d.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" href="css/tables-index.css">
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

        <!-- Button trigger modal --> 
        <div class="d-grid gap-2 d-md-flex justify-content-md-end" style="margin-top:20px; margin-right:20px;">
            <button type="button" class="btn btn-primary modal-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Ask a Question
            </button>
        </div>

        
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ask a Question</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="index.php" method="post">
                    <?php if (count($errors) > 0): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php foreach($errors as $error): ?>

                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <textarea id="" name="question" rows="4" cols="60"></textarea>
                    </div>
                    
                        <!-- </form> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="ask-btn" class="btn btn-primary">Ask</button>
            </div>
            </form>
            </div>
        </div>

        </div>
        

        <div class="container tables-q-index">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col"> <h4>Questions</h4></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($results)) { ?>
                        <tr>
                            <td>
                                <div class="card " style="width: 100%;">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <a class="tables-link" href="answers.php?answer=<?php echo $row['q_id']; ?>">
                                                <?php echo $row['content']; ?>
                                            </a>
                                        </h5>
                                        <h6 class="card-subtitle mb-2 text-muted"></h6>
                                        <p class="card-text" style="text-align:right;">
                                            <?php
                                                $user_id =  $row['user_id'];
                                                $query = "SELECT username FROM users WHERE user_id='$user_id' LIMIT 1";
                                                $stmt = $conn->prepare($query);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                $user = $result->fetch_assoc();
                                                echo $user['username'];
                                            ?>
                                            asked on 
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
    </body>
    <footer class="text-center text-white" style="background-color: #f1f1f1; width:100%;">
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