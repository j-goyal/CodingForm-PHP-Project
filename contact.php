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
        min-height: 76vh;
    }
    </style>


    <title>Contact Us</title>
</head>

<body>

    <?php include 'partials/_header.php'; ?>
    <?php include 'partials/_dbconnect.php'; ?>

    <?php 

        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $content = $_POST['content'];

            if (strlen($name)<=3 or strlen($email)<=5 or strlen($phone)!=10 or strlen($content)<=4)
            {
                echo '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                        <strong>Error !</strong> Please fill the form correctly.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            }
                
            else
            {
                // XSS attack prevention
                $name = str_replace("<", "&lt;", $name);
                $name = str_replace(">", "&gt;", $name);
                $email = str_replace("<", "&lt;", $email);
                $email = str_replace(">", "&gt;", $email);
                $phone = str_replace("<", "&lt;", $phone);
                $phone = str_replace(">", "&gt;", $phone);
                $content = str_replace("<", "&lt;", $content);
                $content = str_replace(">", "&gt;", $content);

                $sql = "INSERT INTO `contacts` (`name`, `email`, `phone`, `content`) VALUES ('$name', '$email', '$phone', '$content');";
                $result = mysqli_query($conn, $sql);

                if($result)
                {
                    echo '<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
                            <strong>Success !</strong> Thankyou for contacting us. Your message has been successfully sent.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
                }
            }
         
        }
    ?>

    <div class="container-fluid px-0">
        <img src="img/contact.jpg" class="d-block w-100 mx-0">
    </div>


    <div class="container my-3" id="maincontainer">
        <h1 class="text-center">Contact Us</h1>
        <form method="post" action='contact.php'>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your Name" required>
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com"
                    required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Your 10-digit Phone Number"
                    required>
            </div>

            <div class="form-group">
                <label for="content">Tell me about what you want to contact me for...</label>
                <textarea class="form-control" id="content" rows="5" name="content" required></textarea>
            </div>
            <button class="btn btn-primary" type="submit">Submit</button>
        </form>

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