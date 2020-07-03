<?php 
    session_start();
    $error_message = '';
    $messageClass = '';
    if (filter_has_var(INPUT_POST, 'submit')) {
        
        // get from data
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $message = htmlspecialchars($_POST['message']);

        // check required field
        if (!empty($email) && !empty($email) && !empty($message)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $error_message = 'Email is not valid';
                $messageClass = 'alert-danger';
            }else {
                $toEmail = 'support@meenachinmay.com';
                $subject = 'Contact Request From ' . $name;
                $body = '<h2>Contact Request </h2>
                        <h4> Name </h4><p>' .$name. '</p>
                        <h4> Email </h4><p>' .$email. '</p>
                        <h4> Message </h4><p>' .$message. '</p>
                        ';

                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-Type:text/html;charset=UTF-8" . "\r\n";
                $headers .= "From: " .$name. "<" .$email. ">". "\r\n";

                if (mail($toEmail, $subject, $body, $headers)) {
                    $error_message = 'Your email has been sent';
                    $messageClass = 'alert-success';
                    $_POST['name'] = "";
                    $_POST["email"] = "";
                    $_POST['message'] = "";
                }else {
                    $error_message = 'Your email was not sent';
                    $messageClass = 'alert-danger';
                }
            }
        }else {
            $error_message = 'Please fill all the fields';
            $messageClass = 'alert-danger';
        }
    }
    session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">         
</head>
<body>
    <nav class="navbar navbar-default bg-dark">
        <div class="container">
            <a class="navbar-brand text-white" href="index.php">My Contact form</a>
        </div>
    </nav>
    <div class="container">
        <?php if ($error_message != ''): ?>
            <div class="mt-3 alert <?php echo $messageClass; ?>"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-control mb-3 mt-3">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" 
                value="<?php echo isset($_POST['name']) ? $name : ''; ?>">
            </div>
            <div class="form-control mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" 
                value="<?php echo isset($_POST['email']) ? $email : ''; ?>">
            </div>
            <textarea class="form-control mb-3" name="message" id="message" cols="15" rows="5">
                <?php echo isset($_POST['message']) ? $message : ''; ?>
            </textarea>
            <button class="btn btn-primary" name="submit" type="submit">Submit</button>
        </form>
    </div>



    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" 
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" 
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" 
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>