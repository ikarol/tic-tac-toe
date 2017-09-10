<?php
declare(strict_types = 1);
namespace Tictactoe\Players;
use Tictactoe\Cell;

class DeterministicComputerPlayer extends Player
{

    public function makeTurn(Cell $cell)
    {
        list($x, $y) = $cell->getCoordinates();
        $this->game->registerTurn($this, "$x, $y");
    }
}
