<?php
use Tictactoe\Players\HumanPlayer;
use Tictactoe\Players\RandomizedComputerPlayer;
use Tictactoe\Gameplay;

require_once('vendor/autoload.php');
$human = new HumanPlayer();
$computer = new RandomizedComputerPlayer();
$game = new Gameplay($human, $computer);


echo <<<HEADER
<!DOCTYPE HTML>
<html>

<head>
<style>
td {
    width: 50px;
    height: 50px;
}
</style>
</head>

HEADER;


echo <<<TABLE
<table border="1">
    <tr>
        <td>
        </td>
        <td>
        </td>
        <td>
        </td>
    </tr>
    <tr>
        <td>
        </td>
        <td>
        </td>
        <td>
        </td>
    </tr>
    <tr>
        <td>
        </td>
        <td>
        </td>
        <td>
        </td>
    </tr>
</table>
TABLE;


echo <<<FOOTER

</html>
FOOTER;
