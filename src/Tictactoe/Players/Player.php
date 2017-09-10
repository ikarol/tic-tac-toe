<?php
declare(strict_types = 1);
namespace Tictactoe\Players;

abstract class Player
{
    abstract protected function makeTurn($cell);

    public function setGame($gameplay)
    {
        $this->game = $gameplay;
    }
}
