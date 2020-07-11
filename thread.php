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
    #ques {
        min-height: 400px;
    }
    </style>

    <title>Welcome to jDiscuss - Coding Forum</title>
</head>

<body>

    <?php include 'partials/_header.php'; ?>
    <?php include 'partials/_dbconnect.php'; ?>

    <?php

        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `threads` WHERE `thread_id`= $id";

        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        
        $thread_title = $row['thread_title'];
        $thread_desc = $row['thread_desc'];
        $thread_user_id = $row['thread_user_id'];

        // query the users table to find out who asked question
        $sql_user = "SELECT * FROM `users` WHERE `user_id`= '$thread_user_id' ";
        $result_user = mysqli_query($conn,  $sql_user);
        $asked_by = mysqli_fetch_assoc($result_user);


    ?>

    <!-- Handle Post Comment -->
    <?php
        $showAlert = false;
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            // Insert thread into database
            $showAlert = true;

            $comment = $_POST['comment'];
            $userid = $_SESSION['userid'];

            $comment = str_replace("<", "&lt;", $comment);
            $comment = str_replace(">", "&gt;", $comment);

            $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`) VALUES ('$comment', '$id', '$userid');";
            $result = mysqli_query($conn, $sql);

            if($showAlert)
            {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> You comment has been posted.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            }
        }

    ?>


    <!-- Display thread -->
    <div class="container">
        <div class="card my-2">
            <div class="card-header" style="font-size: 40px;">
                <?php echo $thread_title; ?>
            </div>
            <div class="card-body">
                <blockquote class="blockquote mb-0" style="text-align: justify;">
                    <p><?php echo $thread_desc; ?></p>
                    <footer class="blockquote-footer" style="font-family: monospace; color: blue;font-size: large;">
                        Asked By : <b><em><?php echo $asked_by['username']; ?> </em></b> 
                        
                    </footer>     
                </blockquote>
            </div>
        </div>
    </div>

    <!-- Post a comment for thread -->
    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
    {
        echo '<div class="container my-4">
                <h1 class="py-2">Post a Comment</h1>

                <form action="' . $_SERVER["REQUEST_URI"] . '" method="post">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Type your comment</label>
                        <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Post Comment</button>
                </form>

                </div>';
    }

    else
    {
        echo '<div class="container my-4">
                <h1 class="py-2">Post a Comment</h1>
                <div class="card-header" style="background-color:dimgrey; color:white;">
                        <p class="margin mb-0">You are not logged in. Please Log in to post a comment.</p5>
                    </div>
            </div>'; 
    }
    
    ?>
    
    
    <!-- Display comments and responses to thread -->
    <div class="container my-3" id="ques">
        <h1 class="py-2">Discussions</h1>

        <?php
                $id = $_GET['threadid'];
                $sql = "SELECT * FROM `comments` WHERE `thread_id` = $id";

                $result = mysqli_query($conn, $sql);
                $empty = true;
                while($row = mysqli_fetch_assoc($result))
                {
                    $empty = false;
                    $comment_content = $row['comment_content'];
                    $comment_by = $row['comment_by'];
                    $comment_thread_id = $row['thread_id'];
                    $comment_time = date("F j, Y, g:i a",strtotime($row['comment_time']));
                    $comment_id = $row['comment_id'];

                    //display username which comment to a thread
                    $sql2 = "SELECT * FROM `users` WHERE `user_id`= $comment_by";
                    $result2 = mysqli_query($conn,  $sql2);
                    $row2 = mysqli_fetch_assoc($result2);

                    echo '<div class="media my-3">
                                <img src="img/user.png" class="mr-3" width="45px" alt="...">
                            <div class="media-body" style="text-align: justify;">
                                <h5 class="mt-0"> '.$row2['username'].'</h5>
                                <h5><footer class="blockquote-footer">'.$comment_time.'</footer></h5>
                               <p>'.$comment_content.'</p>
                            </div>
                        </div>';
                }     

                if($empty)
                {
                    echo '<div class="jumbotron jumbotron-fluid">
                    <div class="container">
                        <p class="display-4">No Comments Found</p>
                        <p class="lead"><b>Be the first person to comment.</b></p>
                    </div>
                    </div>';
                }
        ?>
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