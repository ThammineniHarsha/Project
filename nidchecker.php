<!DOCTYPE html>
<html>
    <head>
        <title>vid checker</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
	    <link rel="stylesheet" href="./css/bootstrap.min.css">
	    <script src="./js/bootstrap.min.js"></script>
	    <link rel="stylesheet" href="./style.css">
    </head>
    <body>
        <div class="container">
        <h1>NOMINEE ID CHECKER</h1>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="form-group">
                    <label for="number">VOTER ID:</label>
                    <input type="text" class="form-control" id="" name="voterid" required>
                </div>
                <div class="form-group">
                    <label for="number">Mobile Number:</label>
                    <input type="text" class="form-control" id="" name="mbn" required><font style="color: red;">(ex:+91xxxxxxxxxx)</font>
                </div>
		        <button type="submit"  class="btn btn-primary" name="submit">Login</button>
            </form>

        </div>
    </body>
</html>
<?php
    session_start();
    require __DIR__ . '/vendor/autoload.php';
	use Twilio\Rest\Client;
    include "dbconnection.php";

    if (isset($_POST['submit'])) {
        $mobilenumber = mysqli_real_escape_string($connection, $_POST['mbn']);
        $voterid = mysqli_real_escape_string($connection, $_POST['voterid']);

        $query = "SELECT * FROM nomineeregistration WHERE voterid='$voterid' && mobilenumber='$mobilenumber'";
        $result = mysqli_query($connection, $query);


        if (mysqli_num_rows($result) == 1) {

            $_SESSION['loggedin'] = true;
            $_SESSION['voterid']=$voterid;
            $_SESSION['mbn']=$mobilenumber;
            $sid = "AC8798f3d9eaab81d30a4b1512c54c3d13";
			$token = "55ed08ec3cda6470cdad7f31b5419bf4";
			$twilio_number="+16076012961";
            $num=rand(1000,9999);
            $_SESSION['otp']=$num;
            $msg="Your Login OTP is ".$num;
			$client = new Client($sid, $token);
			$message=$client->messages->create(
							$mobilenumber,
							array(
								'from' => $twilio_number,
								'body' => $msg
							)
						);
			if ($message->sid) {
				echo "<script>alert('OTP sent successfully')</script>";
				echo "<script> window.location.assign('verifyotp3.php');</script>";
			}
            exit();
        } 
        else
        {
    
            echo "<script>alert('Invalid details');</script>";
        }
    }

    mysqli_close($connection);
?>