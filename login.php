<!DOCTYPE html>
<?php
    include("dbConnect.php");
    session_start();
   
    unset($_SESSION["currentUser"]);
    unset($_SESSION["currentUserID"]);

    if (isset($_POST["action"]) && $_POST["action"]=="login")
    {
        $formUser=$_POST["email"];
        $enteredPass=$_POST["password"];
        $formPass=md5($enteredPass);

        $dbQuery=$db->prepare("select * from fl_users where email=:formUser");
        $dbParams = array('formUser'=>$formUser);
        $dbQuery->execute($dbParams);

        $dbRow=$dbQuery->fetch(PDO::FETCH_ASSOC);

        if ($dbRow["email"]==$formUser)
        {
            if ($dbRow["password"]==$formPass)
            {
                $_SESSION["currentUser"]=$formUser;
                $_SESSION["currentUserID"]=$dbRow["id"];
                //header("Location: /profile.php");
                echo "<script>window.location.href = 'home.php'</script>";
            }
            else
            {
                //header("Location: /login.php?failCode=2");
                echo "<script>window.location.href = 'login.php?failCode=2'</script>";
            }
        }
        else
        {
            //header("Location: /login.php?failCode=1");
            echo "<script>window.location.href = 'login.php?failCode=1'</script>";
        }

    }
    else
    {

?>
<!DOCTYPE html>
<html>
  <head>
    <title>FL | Log in!</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

    <!-- favicons -->
    <link rel="icon" type="image/png" href="http://resources-pl.pulselive.com/ver/i/favicon/favicon-196x196.png" sizes="196x196" />
    <link rel="icon" type="image/png" href="http://resources-pl.pulselive.com/ver/i/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/png" href="http://resources-pl.pulselive.com/ver/i/favicon/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="http://resources-pl.pulselive.com/ver/i/favicon/favicon-16x16.png" sizes="16x16" />
    <link rel="icon" type="image/png" href="http://resources-pl.pulselive.com/ver/i/favicon/favicon-128.png" sizes="128x128" />
    <link rel="shortcut icon" href="http://resources-pl.pulselive.com/ver/i/favicon/favicon.ico" />
  </head>
  <body>
    <div class="container">
      <h1><strong>Fantasy league.</strong></h1>
      <h1><strong>Log in.</strong></h1>

      <?php
        if (isset($_GET["failCode"])) 
        {
          if ($_GET["failCode"]==1)
            echo "<h3 style='color:red; text-align: center;'>Bad email entered</h3>";
            if ($_GET["failCode"]==2)
              echo "<h3 style='color:red; text-align: center;'>Bad password entered</h3>";
            if ($_GET["failCode"]==3)
            {
              echo "<h3 style='color:red; text-align: center;'>Login or register to enrol on this course</h3>";

              if (isset($_GET["courseid"]))
              {
                $courseid = $_GET["courseid"];
              }
            }
          }
      ?>

      <form method="post" action="login.php" style="width:500px;text-align:left;margin: 0 auto;" class="w3-container">

        <input class="w3-input" name="email" placeholder="Email" type="email">

        <input class="w3-input" name="password" placeholder="Password" type="password">

        <input class="w3-input w3-purple" type="submit" value="Log in">

        <input type="hidden" name="action" value="login">

      </form>

      <p><a href="index.html">or register here</a></p>

    </div>
  </body>
</html>

<?php
}
?>
