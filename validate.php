<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
	<body>
		<div class="wrapper mybox">
    <!-- Navigation -->
    <nav class="main-nav">
      <ul>
        <li>
          <a href="index.php">Home</a>
        </li>
        <li>
          <a href="#">About</a>
        </li>
        <li>
          <a href="#">Services</a>
        </li>
        <li>
          <a href="#">Contact</a>
        </li>
      </ul>
    </nav>

    <!-- Top Container -->
    <section class="top-container">
      <header class="showcase">
        <div class="myform">
			<h1>Supply your unique pin</h1>
			<form action="validate.php" method="POST">
      <?php
            if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
            {
              require_once('connect_db.php');

              # Check pin.
              $gp = mysqli_real_escape_string( $dbc, trim( $_POST[ 'gen_pin' ] ) ) ;
              $gp2 = SHA1($gp);
              
              # Check if pin is available.
              $q = "SELECT * FROM user WHERE gen_pin='$gp2'" ;
              $r = @mysqli_query ( $dbc, $q ) ;
              if ( mysqli_num_rows( $r ) != 0 ) {
              
                if ( mysqli_num_rows( $r ) > 0 ){
                  while($row = mysqli_fetch_array( $r, MYSQLI_ASSOC )){
                    echo '<div class="alert alert-info">';
                    echo 'Your Detail: <br />'.
                    '<strong>Name: </strong>' .$row['name'].
                    '<br /><div><strong>Phone: </strong>'.$row['phone'].'</div>
                    <div><strong>Email: </strong>'.$row['email'].'</div>
                    <div><strong>PIN: </strong>'.$gp.'</div>
                    </div>';
                  }
                }
              }
              else{
                echo '<div class="alert alert-danger">
                <strong>Alert!</strong> Incorrect Pin!!!
                </div>';
              }
             
                  # Close database connection.
                  mysqli_close($dbc);
              }
            ?>
		  	<p><input type="text" placeholder="Your 10-digit pin.." name="gen_pin" required/></p>
			<p><input type="submit" value=SUBMIT /></p>
		  </form>
		</div>
      </header>
    </section>
	</body>

    <!-- Footer -->
    <footer>
      <p>Oluyinka Abubakar &copy; 2020</p>
    </footer>

  </div>
  <!-- Wrapper Ends -->