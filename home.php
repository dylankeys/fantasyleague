<!DOCTYPE html>
<html>
  <head>
    <title>FL | Home</title>

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

      <?php
        session_start();
        include ("dbConnect.php");

        if (!isset($_SESSION["currentUserID"]))
        {
            //header("Location: login.php");
            echo "<script>window.location.href = 'login.php'</script>";
        }

        $id=$_SESSION["currentUserID"];

        $dbQuery=$db->prepare("select * from fl_users where id=:id");
        $dbParams = array('id'=>$id);
        $dbQuery->execute($dbParams);
        $dbRow=$dbQuery->fetch(PDO::FETCH_ASSOC);
        $fullname=$dbRow["fullname"];
      ?>
	</head>

	<body>

    <div class="container"><br>
    <h1><strong>Fantasy league.</strong></h1>
    <h1><strong>Home.</strong></h1>

      <?php
        echo "<h5 style='padding:10px;'>Logged in as ". $fullname ."</h5>";
      ?>
      
      <?php
        $dbQuery=$db->prepare("select value from fl_config where setting=:setting");
        $dbParams=array('setting'=>"poll_status");
        $dbQuery->execute($dbParams);
        $dbRow=$dbQuery->fetch(PDO::FETCH_ASSOC);
        $status=$dbRow["value"];

        if($status=='active')
        {
          echo "<h2><strong>Vote for a provider</strong></h2>";

          $dbQuery3=$db->prepare("select userid from fl_poll_votes where userid=:id");
          $dbParams3=array('id'=>$id);
          $dbQuery3->execute($dbParams3);
          $votecount=$dbQuery3->rowCount();

          if($votecount<1)
          {

            echo '<form style="width:200px;margin: 0 auto;" method="post" action="poll.php">';
        
            $dbQuery2=$db->prepare("select * from fl_poll");
            $dbQuery2->execute();
   
            while ($dbRow2 = $dbQuery2->fetch(PDO::FETCH_ASSOC)) 
            {
              $option=$dbRow2["option"];
              echo '<input class="w3-radio" type="radio" name="polloption" value="'. $option .'">';
              echo '<label>'.$option.'</label><br>';
            }
            echo '<input type="hidden" name="userid" value="'. $id .'">';
            echo '<input type="submit" class="w3-input w3-purple" value="Vote">';
            echo '</form>';
          }
          else
          {
            echo '<p>You have already voted, current results:</p>';
            echo '<table class="w3-table" style="width:500px;margin: 0 auto;">';

            $dbQuery4=$db->prepare("select * from fl_poll");
            $dbQuery4->execute();
   
            while ($dbRow4 = $dbQuery4->fetch(PDO::FETCH_ASSOC)) 
            {
              $totalvotes+=$dbRow4["votes"];
            }

            $dbQuery5=$db->prepare("select * from `fl_poll`");
            $dbQuery5->execute();
   
            while ($dbRow5 = $dbQuery5->fetch(PDO::FETCH_ASSOC)) 
            {
              $option=$dbRow5["option"];
              $votes=$dbRow5["votes"];
              $percent=$votes/$totalvotes*100;

              $totalvotes+=$dbRow2["votes"];

              echo '<tr><td style="width:25%;margin-top:-10px"><p>'.$option.'</p></td>
              <td style="width:75%">
                <div class="w3-light-grey">
                  <div class="w3-container w3-purple w3-center" style="width:'.$percent.'%">'.$votes.'</div>
                </div>
              </td></tr>';

            }
            echo '</table>';
          }


        } 
      ?>

      <h2><strong>League PIN</strong></h2>
        <?php
          $dbQuery=$db->prepare("select value from fl_config where setting=:setting");
          $dbParams=array('setting'=>"leaguepin");
          $dbQuery->execute($dbParams);
          $dbRow=$dbQuery->fetch(PDO::FETCH_ASSOC);
          $pin=$dbRow["value"];
          echo "<h2>". $pin ."</h2>";
        ?>
      <hr>
      <button class="w3-btn w3-purple" style="padding:10px;" onclick="window.location.href='killSession.php'">Log off</button>
    </div>
	</body>
</html>