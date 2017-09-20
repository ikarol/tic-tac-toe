<?php
declare(strict_types = 1);
namespace Tictactoe\Players;
use Tictactoe\Cell;

class HumanPlayer extends Player
{

    public function makeTurn(Cell $cell)
    {
        $this->game->registerTurn($this, $cell);
    }
}
