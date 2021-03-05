<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $_SERVER['REQUEST_URI'] ?></title>
    <meta http-equiv="refresh" content="5">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
    <style>
      table, th, td {
          border: 1px solid black;
          border-collapse: collapse;
      }
    </style>
  </head>
  <!--

  This script updates the table 'votes_participation'

  -->
  <body>
    <?php
      $url = $_SERVER['REQUEST_URI'];
      $url = str_replace(array("/", "datan", "scripts", "votes_", ".php"), "", $url);
      $url_current = substr($url, 0, 1);
      $url_second = $url_current + 1;
    ?>
		<div class="container" style="background-color: #e9ecef;">
			<div class="row">
				<h1><?= $_SERVER['REQUEST_URI'] ?></h1>
			</div>
			<div class="row">
				<div class="col-4">
					<a class="btn btn-outline-primary" href="./" role="button">Back</a>
				</div>
				<div class="col-4">
					<a class="btn btn-outline-secondary" href="http://<?php echo $_SERVER['SERVER_NAME']. ''.$_SERVER['REQUEST_URI'] ?>" role="button">Refresh</a>
				</div>
				<div class="col-4">
					<a class="btn btn-outline-success" href="./votes_9.1.php" role="button">NEXT</a>
				</div>
			</div>
			<div class="row mt-3">
        <div class="col-12">
          <h2 class="bg-danger">This script needs to be refreshed until the table below is empty. The scripts automatically is automatically refreshed every 5 seconds.</h2>
        <?php

        // CONNEXION SQL //
        	include 'bdd-connexion.php';

          $result = $bdd->query('
          SELECT voteNumero
          FROM votes_participation
          ORDER BY voteNumero DESC
          LIMIT 1
          ');

        while ($last = $result->fetch()) {
          echo '<p>Last vote: '.$last['voteNumero'].'</p>';
          $last_vote = $last['voteNumero'];
          $until_vote = $last_vote + 10;
          echo 'until vote = '.$until_vote.'<br>';
          $legislature = 15;
        }

        if (!isset($until_vote)) {
          echo 'rien dans la base';
          $last_vote = 0;
          $until_vote = 2;
          $legislature = 15;
        }

        $bdd->query('SET SQL_BIG_SELECTS=1');

        echo '<br>';

        $votes = $bdd->query('
          SELECT voteNumero, legislature, dateScrutin
          FROM votes_info
          WHERE voteNumero > "'.$last_vote.'" AND voteNumero <= "'.$until_vote.'" AND legislature = 15
        ');

        if ($votes->rowCount() == 0) {
          $new_vote = $last_vote + 1;
          $until_vote = $new_vote + 2;
          echo "Need to jump a vote.<br>";
          echo "NEW VOTE = ".$new_vote;
          $votes = $bdd->query('
            SELECT voteNumero, legislature, dateScrutin
            FROM votes_info
            WHERE voteNumero > "'.$new_vote.'" AND voteNumero <= "'.$until_vote.'" AND legislature = 15
          ');
        }

        while ($vote = $votes->fetch()) {
          echo '<h1>Chercher députés pour = '.$vote['voteNumero'].'</h1>';
          $voteNumero = $vote['voteNumero'];
          $voteDate = $vote['dateScrutin'];
          echo 'date = '.$voteDate.'<br>';
          echo 'voteNumero = '.$voteNumero.'<br>';
          $deputes = $bdd->query('
            SELECT *
            FROM mandat_principal m
            LEFT JOIN deputes d ON d.mpId = m.mpId
            WHERE ((m.datePriseFonction < "'.$voteDate.'" AND m.dateFin > "'.$voteDate.'") OR (m.datePriseFonction < "'.$voteDate.'" AND m.dateFin IS NULL)) AND m.legislature = 15 AND m.typeOrgane = "ASSEMBLEE" AND m.codeQualite = "membre" AND m.preseance = 50
          ');

          $i = 1;
          while ($depute = $deputes->fetch()) {
            echo $i.' - '.$depute['mpId'].' - '.$vote['voteNumero'].' - voteId : '.$voteNumero.' - ';
            $mpId = $depute['mpId'];
            $voted = $bdd->query('
              SELECT vote
              FROM votes
              WHERE mpId = "'.$mpId.'" AND legislature = 15 AND voteNumero = "'.$voteNumero.'"
            ');

            if ($voted->rowCount() > 0) {
              while ($x = $voted->fetch()) {
                $v = $x["vote"];
              }
              if ($v == "nv") {
                $participation = NULL;
              } else {
                $participation = 1;
              }
            } else {
              $participation = 0;
            }

            echo 'participation = '.$participation.'<br>';
            $i++;

            $sql = $bdd->prepare("INSERT INTO votes_participation (legislature, voteNumero, mpId, participation) VALUES (:legislature, :voteNumero, :mpId, :participation)");
            $sql->execute(array('legislature' => $legislature, 'voteNumero' => $voteNumero, 'mpId' => $mpId, 'participation' => $participation));
          }
        }

        ?>
        </div>
      </div>
    </div>
  </body>
</html>
