<?php

require 'Tictactoe.php';
require 'Player.php';
require 'Botdon.php';

// run in the command line and watch
$game = new Tictactoe;
$game->setPlayers(new Botdon, new Botdon);
$game->run();

?>