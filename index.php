<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <style>
        #ques{
            min-height: 433px;
        }
    </style>

    <title>Welcome to jDiscuss - Coding Forum</title>
</head>

<body>

    <?php include 'partials/_header.php'; ?>
    <?php include 'partials/_dbconnect.php'; ?>


    <!-- Alerts for signup success or failure -->
    <?php 
    
        if(isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "true")
        {
            echo '<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
                    <strong>Success !</strong> You account has been successfully created and now you can login.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        }
    
        else if (isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "false")
        {
            echo '<div class="alert alert-danger alert-dismissible fade show mb-0"  role="alert">
                    <strong>Error !</strong> '.$_GET['error'].'
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        }
    
    ?>

    <!-- Alerts for Login success or failure -->
    <?php 
        if(isset($_GET['loginsuccess']) && $_GET['loginsuccess'] == "true")
        {
            echo '<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
                    <strong>Success !</strong> Logged in Successfully as - <b>'.$_SESSION['username'].'</b>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        }
    
        else if (isset($_GET['loginsuccess']) && $_GET['loginsuccess'] == "false")
        {
            echo '<div class="alert alert-danger alert-dismissible fade show mb-0"  role="alert">
                    <strong>Error !</strong> '.$_GET['error'].'
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        }
    
    ?>

     <!-- Alert for Logout -->
     <?php 
        if(isset($_GET['logged']) && $_GET['logged'] == "true")
        {
            echo '<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
                    <strong>Success !</strong> Logged Out Successfully
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        }
    ?>

    <!-- slider starts -->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/slider1.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="img/slider2.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="img/slider3.jpg" class="d-block w-100" alt="...">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <!-- category container stars here -->
    <div class="container" id="ques">
        <h1 class="text-center my-3">jDiscuss Categories</h1>

        <div class="row">
            <!-- fetch all categories -->
            <?php
                    $sql = "SELECT * FROM `categories`";
                    $result = mysqli_query($conn, $sql);

                    while($row = mysqli_fetch_assoc($result))
                    {
                    //use a for loop to iterate through categories
                    $cat =  $row['category_name'];
                    $cat_desc = $row['category_description'];
                    $cat_id = $row['category_id'];
                        echo '<div class="col-md-4 my-2">
                                <div class="card" style="width: 18rem;">
                                    <img src="img/img'.$cat_id.'.jpg" class="card-img-top"
                                        alt="..." width="260" height="250">
                                    <div class="card-body">
                                        <h5 class="card-title"> <a href="threadlist.php?catid='.$cat_id.'"> '.$cat.' </a></h5>
                                        <p class="card-text">'. substr($cat_desc, 0, 93).'.......</p>
                                        <a href="threadlist.php?catid='.$cat_id.'" class="btn btn-primary">View Threads</a>
                                    </div>
                                </div>
                            </div>';
                    }
            ?>



        </div>
    </div>

    <?php include 'partials/_footer.html'; ?>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
</body>

</html>