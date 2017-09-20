<?php
declare(strict_types = 1);
namespace Tictactoe\Players;
use Tictactoe\Cell;
use Tictactoe\Exceptions\CellIsNotEmptyException;

class RandomizedComputerPlayer extends Player
{

    public function makeRandomizedTurn()
    {
        $board = $this->game->getEmptyBoard();
        $range = array_keys($board);
        $min = min($range);
        $max = max($range);
        $cellIsEmpty = false;
        while (!$cellIsEmpty) {
            try {
                $coordinates = array_map('intval',  explode(', ', $board[mt_rand($min, $max)]));
                list($x, $y) = $coordinates;
                $this->makeTurn(new Cell($x, $y));
                $cellIsEmpty = true;
            } catch (CellIsNotEmptyException $e) {
                // do nothing
            }
        }
    }

    protected function makeTurn(Cell $cell)
    {
        $this->game->registerTurn($this, $cell);
    }
}
