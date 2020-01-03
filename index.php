<?php
  include_once('header.html');
?>

    <!-- Top Container -->
    <section class="top-container">
      <header class="showcase">
        <div class="myform">
			<h1>Fill the form below</h1>
			<form action="index.php" method="POST">
      <?php

            if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
            {
              require_once('connect_db.php');

              # To insert name.
              $nm = mysqli_real_escape_string( $dbc, trim( $_POST[ 'name' ] ) ) ;

              # To insert phone.
              $ph = mysqli_real_escape_string( $dbc, trim( $_POST[ 'phone' ] ) ) ;

              # To insert email.
              $em = mysqli_real_escape_string( $dbc, trim( $_POST[ 'email' ] ) ) ;

              # Check if email is already registered.
              $q = "SELECT user_ID FROM user WHERE email='$em'" ;
              $r = @mysqli_query ( $dbc, $q ) ;
              if ( mysqli_num_rows( $r ) != 0 ) {
              echo '<div class="alert alert-danger">
              <strong>Alert!</strong> This email is linked to a record in our database already!!!
              </div>';
              }
              else{
                # Create random value.
                $gp = 0;
                $gp = mt_rand(1000000000,9999999999);

                # Check to avoid duplicate random values in database.
                $q = "SELECT * FROM user WHERE gen_pin=SHA1('$gp')" ;
                $r = @mysqli_query ( $dbc, $q ) ;
                if ( mysqli_num_rows( $r ) != 0 ) {
                  header("Location: index.php");
                }
                # Insert values into database
                $q = "INSERT INTO user (name, phone, email, gen_pin) VALUES ('$nm', '$ph', '$em', SHA1('$gp'))";
                $r = @mysqli_query ( $dbc, $q ) ;

                  // Unsing PHPMailer for sending messages
                  require 'PHPMailerAutoload.php';
                  require 'credential.php';
                  
                  $mail = new PHPMailer;

                  $mail->SMTPDebug = 0;                                 // Enable verbose debug output

                  $mail->isSMTP();                                      // Set mailer to use SMTP
                  $mail->Host = 'smtp.gmail.com;';                      // Specify main and backup SMTP servers
                  $mail->SMTPAuth = true;                               // Enable SMTP authentication
                  $mail->Username = EMAIL;                              // SMTP username
                  $mail->Password = PASS;                               // SMTP password
                  $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                  $mail->Port = 587;                                    // TCP port to connect to

                  $mail->setFrom('info@solutiontotest.com', 'Authentication Center');
                  $mail->addAddress($em);                               // Add a recipient

                  $mail->isHTML(true);                                  // Set email format to HTML

                  $mail->Subject = 'Verify your registration';
                  $mail->Body    = 'Thank you for registering: Your unique key is: ' .$gp. '<br />'.
                                    '<a href="http://localhost/solution/solution/validate.php"><br />Click here to verify your detail</a>';
                 
                  if($mail->send()) {
                    echo '<div class="alert alert-success" style="text-align:center">';
                    echo '<strong>Success!</strong> Thank you ' .$nm. ' for filling out the form!!! Check your email to verify your detail';
                    echo '</div>';
                  }

                  # Close database connection.
                  mysqli_close($dbc);
              }
            }
            ?>
		  	<p><input type="text" placeholder="Your name.." name="name" required/></p>
				<p><input type="phone" placeholder="Your phone number.." name="phone" required/></p>
				<p><input type="email" placeholder="Your email address.." name="email" required/></p>
				<p><input type="submit" value=SUBMIT /></p>
		  </form>
		</div>
      </header>
    </section>
	</body>
  <?php
    include_once('footer.html');
  ?>