<?php
declare(strict_types = 1);
namespace Tictactoe\Players;
use Tictactoe\Cell;
use Tictactoe\Gameplay;

abstract class Player
{
    abstract protected function makeTurn(Cell $cell);

    public function setGame(Gameplay $gameplay)
    {
        $this->game = $gameplay;
    }
}
