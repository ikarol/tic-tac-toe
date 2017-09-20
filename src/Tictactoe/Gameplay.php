<?php
declare(strict_types = 1);
namespace Tictactoe;
use Tictactoe\Exceptions\DrawException;
use Tictactoe\Exceptions\CellIsNotEmptyException;
use Tictactoe\Players\Player;

class Gameplay
{
    private $playerOne;
    private $playerTwo;
    private $playerOneSign;
    private $playerTwoSign;
    private $winner;
    private $emptyBoard = [
        '0, 0',
        '0, 1',
        '0, 2',
        '1, 0',
        '1, 1',
        '1, 2',
        '2, 0',
        '2, 1',
        '2, 2'
    ];
    private $gameBoard = [
        'X' => [],
        'O' => [],
    ];
    private $winCombinations = [
        'horizontal' => [
            [
                '0, 0',
                '0, 1',
                '0, 2'
            ],
            [
                '1, 0',
                '1, 1',
                '1, 2'
            ],
            [
                '2, 0',
                '2, 1',
                '2, 2'
            ],
        ],
        'vertical' => [
            [
                '0, 0',
                '1, 0',
                '2, 0'
            ],
            [
                '0, 1',
                '1, 1',
                '2, 1'
            ],
            [
                '0, 2',
                '1, 2',
                '2, 2'
            ],
        ],
        'diagonal' => [
            [
                '0, 0',
                '1, 1',
                '2, 2'
            ],
            [
                '2, 0',
                '1, 1',
                '0, 2'
            ],
        ]
    ];

    public function __construct(Player $playerOne, Player $playerTwo)
    {
        $this->playerOne = $playerOne;
        $this->playerOne->setGame($this);
        $this->playerOneSign = 'X';
        $this->playerTwo = $playerTwo;
        $this->playerTwo->setGame($this);
        $this->playerTwoSign = 'O';
    }

    public function isCellEmpty(Cell $cell): bool
    {
        return in_array((string)$cell, $this->emptyBoard, true);
    }

    public function startGame(): bool
    {
        return true;
    }

    public function getWinner(): Player
    {
        return $this->winner;
    }

    public function getEmptyBoard(): array
    {
        return $this->emptyBoard;
    }

    public function registerTurn(Player $player, Cell $cell)
    {
        if (!$this->isCellEmpty($cell)) {
            throw new CellIsNotEmptyException();
        }
        $sign = $this->getSignByPlayer($player);
        $this->gameBoard[$sign][] = (string)$cell;
        unset($this->emptyBoard[array_search((string)$cell, $this->emptyBoard)]);
        $this->emptyBoard = array_values($this->emptyBoard);
        foreach ($this->winCombinations as $axis) {
            foreach ($axis as $type) {
                if (count(array_intersect($type, $this->gameBoard[$sign])) <> 3) {
                    continue;
                }
                $this->setWinner($sign);
                break;
            }
        }
        $this->isGameFinished();
    }

    private function isGameFinished(): bool
    {
        if (empty($this->winner)) {
            if (empty($this->emptyBoard)) {
                throw new DrawException();
            }
            return false;
        }
        return true;
    }

    private function getSignByPlayer(Player $player): string
    {
        if ($player === $this->playerOne) {
            return 'X';
        } elseif ($player === $this->playerTwo) {
            return 'O';
        }
    }

    private function setWinner(string $sign)
    {
        $this->winner = $sign === 'X' ? $this->playerOne : $this->playerTwo;
    }

}
