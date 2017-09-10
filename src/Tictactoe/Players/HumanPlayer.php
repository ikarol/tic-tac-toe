<?php
declare(strict_types = 1);
namespace Tictactoe\Players;

class HumanPlayer extends Player
{
    protected $game;

    public function makeTurn($cell)
    {
        list($x, $y) = $cell->getCoordinates();
        $this->game->registerTurn($this, "$x, $y");
    }
}
