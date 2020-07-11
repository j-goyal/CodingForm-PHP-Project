<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">


    <style>
    #ques {
        min-height: 400px;
    }
    </style>


</head>

<body>

    <?php include 'partials/_header.php'; ?>
    <?php include 'partials/_dbconnect.php'; ?>


    <!-- Handle Ask a question form -->
    <?php
        $showAlert = false;
        $id = $_GET['catid'];
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            // Insert thread into database
            $showAlert = true;

            $title = $_POST['title'];
            $desc = $_POST['desc'];
            $userid = $_SESSION['userid'];

            // XSS attacks(do not run tags)
            $title = str_replace("<", "&lt;", $title);
            $title = str_replace(">", "&gt;", $title);
            $desc = str_replace("<", "&lt;", $desc);
            $desc = str_replace(">", "&gt;", $desc);

            $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`) VALUES ('$title', '$desc', '$id', '$userid')";
            $result = mysqli_query($conn, $sql);

            if($showAlert)
            {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> You thread has been added! Please wait for community to respond.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            }
        }
        
    ?>

    <!-- Display our forum using jumbotron -->
    <?php
        

        $id = $_GET['catid'];
        $sql = "SELECT * FROM `categories` WHERE `category_id`= $id";

        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        $cat_name = $row['category_name'];
        $cat_desc = $row['category_description'];

    ?>
    <title><?php echo $cat_name?> - Forum</title>
    
    <div class="container">
        <div class="jumbotron my-2">
            <h1 class="display-4">Welcome to <?php echo $cat_name; ?> Forum</h1>
            <p class="lead"><?php echo $cat_desc; ?></p>
            <hr class="my-4">
            <h5 style="text-decoration: underline;"><b>Forum rules:</b></h5>
            <p>
                <ul>
                    <li>No Spam / Advertising / Self-promote in the forums.</li>
                    <li>Do not post copyright-infringing material.</li>
                    <li>Do not post “offensive” posts, links or images.</li>
                    <li>Remain respectful of other members at all times.</li>
                </ul>
            </p>
            <!-- <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a> -->
        </div>
    </div>


    <!-- Ask a question -->
    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
    {
        echo '<div class="container my-4">
                <h1 class="py-2">Ask a Question</h1>

                <form action="' . $_SERVER["REQUEST_URI"] . '" method="post">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Problem Title</label>
                        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                        <small id="emailHelp" class="form-text text-muted">Keep your title as short and crisp as
                            possible.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Elaborate Your Problem</label>
                        <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>';
    }

    else
    {
        echo '<div class="container my-4">
                <h1 class="py-2">Ask a Question</h1>
                <div class="card-header" style="background-color:dimgrey; color:white;">
                        <p class="margin mb-0">You are not logged in. Please Log in to ask a question.</p5>
                    </div>
            </div>'; 
    }
    
    ?>


    <!-- Display questions asked by users -->
    <div class="container my-3" id="ques">
        <h1 class="py-3">Browse Questions</h1>
        <?php 
                    $id = $_GET['catid'];
                    $sql = "SELECT * FROM `threads` WHERE `thread_cat_id` = $id";
                    $result = mysqli_query($conn, $sql);
                    $empty = true;
                    $num_of_rows = mysqli_num_rows($result);
                    if($num_of_rows > 0)
                    {
                        echo '<table class="table pt-3 mb-2" id="myTable">
                                    <thead>
                                     <tr>
                                        <th scope="col" style="color:darkred; text-align: center;">S.No</th>
                                        <th scope="col" style="color:darkred; text-align: center;">Question</th>
                                        <th scope="col" style="color:darkred; text-align: center;">Description</th>
                                        <th scope="col" style="color:darkred; text-align: center;">Asked By (when)</th>
                                     </tr>
                                    </thead>
                                <tbody>';
                        $sno = 0;
                        while($row = mysqli_fetch_assoc($result))
                        {
                            $sno = $sno + 1;
                            $empty = false;
                            $thread_name = $row['thread_title'];
                            $thread_desc = $row['thread_desc'];
                            $thread_id = $row['thread_id'];
                            $thread_user_id = $row['thread_user_id'];
                            $thread_time = date("F j, Y, g:i a",strtotime($row['timestamp']));

                            // select username corresponding to thread 
                            $sql2 = "SELECT * FROM `users` WHERE `user_id`=$thread_user_id";
                            $result2 = mysqli_query($conn,  $sql2);
                            $row2 = mysqli_fetch_assoc($result2);
                            $asked_by = $row2['username'];
                            echo ' <tr>
                                        <th style="text-align: center;"scope="row">'. $sno . '</th>
                                        <td><a href="thread.php?threadid='.$thread_id.'"> '. $thread_name .' </a></td>
                                        <td style="text-align: justify;">'. substr($thread_desc, 0, 40) .'.....</td>
                                        <td style="text-align:center;"><b><em style="color:green;">'.$asked_by.'</em></b> on ('. $thread_time.') </td>
                                    </tr>';        
                        } 

                    }
                    else
                    {
                        echo '<div class="jumbotron jumbotron-fluid">
                        <div class="container">
                            <p class="display-4">No Threads Found</p>
                            <p class="lead"><b>Be the first person to ask a question.</b></p>
                        </div>
                        </div>';
                    }
                    
          ?>
        </tbody>
        </table>
    </div>


    <!-- <div class="container my-3" id="ques">
        <h1 class="py-2">Browse Questions</h1>
        
        <?php
                //$views = 1;
                $id = $_GET['catid'];
                $sql = "SELECT * FROM `threads` WHERE `thread_cat_id` = $id";

                $result = mysqli_query($conn, $sql);
                $empty = true;
                while($row = mysqli_fetch_assoc($result))
                {    
                    $empty = false;
                    $thread_name = $row['thread_title'];
                    $thread_desc = $row['thread_desc'];
                    $thread_id = $row['thread_id'];
                    $thread_user_id = $row['thread_user_id'];
                    $thread_time = date("F j, Y, g:i a",strtotime($row['timestamp']));

                    // select username corresponding to thread 
                    $sql2 = "SELECT * FROM `users` WHERE `user_id`=$thread_user_id";
                    $result2 = mysqli_query($conn,  $sql2);
                    $row2 = mysqli_fetch_assoc($result2);
                    //$row2['username']

                    echo '<div class="media my-4">
                                <img src="img/user.png" class="mr-3" width="45px" alt="...">
                            <div class="media-body">
                                <h5 class="mt-0"> <a href="thread.php?threadid='.$thread_id.'">'. $thread_name .' </a></h5>
                                <h5><footer class="blockquote-footer">Asked By <em><b>'.$row2['username'].'</b></em> -- '.$thread_time.'</footer></h5>
                                <p style="text-align: justify;">'.$thread_desc.'</p>
                            </div>
                        </div>';
                }     

                if($empty)
                {
                    echo '<div class="jumbotron jumbotron-fluid">
                    <div class="container">
                        <p class="display-4">No Threads Found</p>
                        <p class="lead"><b>Be the first person to ask a question.</b></p>
                    </div>
                    </div>';
                }
        ?>
    </div> -->




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
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();

    });
    </script>

</body>

</html>