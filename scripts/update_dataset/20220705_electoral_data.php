<?php
  include('../bdd-connexion.php');

  $bdd->query('DROP TABLE IF EXISTS elect_2017_leg_results');
  $bdd->query('DROP TABLE IF EXISTS elect_2017_leg_infos');

  $file = file_get_contents('sql/elect_legislatives_infos.sql');
  $bdd->exec($file);

  $file = file_get_contents('sql/elect_legislatives_results.sql');
  $bdd->exec($file);
