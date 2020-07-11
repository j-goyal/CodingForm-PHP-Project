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
    #maincontainer {
        min-height: 90vh;
    }
    </style>

    <title>Search Results</title>
</head>

<body>

    <?php include 'partials/_header.php'; ?>
    <?php include 'partials/_dbconnect.php'; ?>



    <div class="container" id="maincontainer">
        <div class="card-header my-4" style="background-color:seagreen; color:white;">
            <h3 class="margin mb-0">Search Results for <em>"<?php echo $_GET['query'] ?>"</em>:</h3>
        </div>
        <?php 
        
            $noresults = true;
            //$query = htmlentities($_GET["query"]);
            $query = $_GET["query"];

            //echo var_dump($query);

           /*  $query = str_replace("<", "&lt;", $query);
            $query = str_replace(">", "&gt;", $query); */
            // echo var_dump($query);

            $sql = "SELECT * FROM `threads` WHERE MATCH(thread_title,thread_desc) against ('$query')";

            $result = mysqli_query($conn, $sql);
            
            while($row = mysqli_fetch_assoc($result))
            {
                $noresults = false;
                $thread_name = $row['thread_title'];
                $thread_desc = $row['thread_desc'];
                $thread_id = $row['thread_id'];
                $url = "thread.php?threadid='.$thread_id.";

                echo '<div class="results py-2">
                        <ul>
                        <li><h3> <a href="'.$url.'">'.$thread_name.'</a></h3>
                        <p>'.$thread_desc.'</p></li>
                        <ul>
                     </div>';
            }

            if($noresults)
            {
                echo '<div class="jumbotron">
                <h1 class="display-4">No Results Found</h1>
                <hr class="my-4">
                <p>Suggestions:
                <ul>
                <li>Make sure that all words are spelled correctly.</li>
                <li>Try different keywords.</li>
                <li>Try more general keywords.</li>
                </p>
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