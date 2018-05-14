<?php
   

  if(isset($_POST['login']))
  {
    $username = $_POST['username'];
    $password = $_POST['password'];

    include_once("connection.php");
    mysql_select_db($dbName);

    $sql = "SELECT * FROM users WHERE username = '$username';" ;
    $result = mysql_query($sql);

      if (!$result)
      {
        die ("Query Failed: ".mysql_error());
      }

      else
      {
      $row = mysql_fetch_array($result);


            if ($row['username'] == '')
              echo ("ERROR! User does not exist!");

            else if (!($password == $row['password']))
              echo ("ERROR! Incorrect Password!");

            else
              {
              
              session_start();
              $_SESSION['ID'] = $row['userID'];
              header("Location:adminpage.php");
              }

      }
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Housebrew-Coffee</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="../css/mdb.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="css/style.css" rel="stylesheet">
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Serif:300,400" rel="stylesheet">
</head>

<body>
  <!-- Main Navigation -->
  <header>
  
    <div id="intro" class="view">
      <div class="container-fluid full-bg-img d-flex align-items-center justify-content-center">
        <div class="row d-flex justify-content-center">
          <div class="col-sm-12 col-md-12 text-center">
            <!-- Heading -->
            <h1 id="housebrew-heading" class="h1-responsive font-bold white-text mb-2 animated flipInX">Housebrew</h1>
            <!-- Heading -->
             <main>
      <div class="container" style="background-color: brown;">
         <form class="col s12 l12" method="post">
             <div> 
              <div ><h5><b>Sign in,</b></h5></div>
             <div >
                  <b>to Continue to Admin Page</b>
              </div>
        </div>
             <div>
              <div>
                <label for='username'>Username</label>
                <input class='validate' type='text' name='username' id='username' data-length="10" />
              </div>
        </div> 
            <div>
            <div>
                <label for='password'>Password</label>
                <input class='validate' type='password' name='password' id='password' />
              </div> 
            </div>

            <br />
            <center>
              <div class='row'>
                <button id="login" type="submit" name="login">Login
                </button>
              </div>
            </center>
          </form>
      </div>
    </main>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- Main Navigation -->
  <!-- Main Body -->
   
  <!-- Main Body -->



  <!-- SCRIPTS -->

  <!-- JQuery -->
  <script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="../js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="../js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="../js/mdb.min.js"></script>
  <!-- Custom Script -->
  <script language="JavaScript" type="text/javascript" src="js/init.js"></script>
</body>

</html>
