<?php
declare(strict_types = 1);
namespace Tictactoe;
use Tictactoe\Exceptions\DrawException;
use Tictactoe\Exceptions\CellIsNotEmptyException;

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

    public function __construct($playerOne, $playerTwo)
    {
        $this->playerOne = $playerOne;
        $this->playerOne->setGame($this);
        $this->playerOneSign = 'X';
        $this->playerTwo = $playerTwo;
        $this->playerTwo->setGame($this);
        $this->playerTwoSign = 'O';
    }

    public function isCellEmpty(int $x, int $y): bool
    {
        return in_array("$x, $y", $this->emptyBoard, true);
    }

    public function startGame(): bool
    {
        return true;
    }

    public function getWinner()
    {
        return $this->winner;
    }

    public function registerTurn($player, string $coordinates)
    {
        list($x, $y) = array_map('intval', explode(', ', $coordinates));
        if (!$this->isCellEmpty($x, $y)) {
            throw new CellIsNotEmptyException();
        }
        $sign = $this->getSignByPlayer($player);
        $this->gameBoard[$sign][] = $coordinates;
        unset($this->emptyBoard[array_search($coordinates, $this->emptyBoard)]);
        $this->isGameFinished($sign);
    }

    private function isGameFinished(string $sign): bool
    {
        if (empty($this->emptyBoard)) {
            throw new DrawException();
        }
        foreach ($this->winCombinations as $axis) {
            foreach ($axis as $type) {
                if (count(array_intersect($type, $this->gameBoard[$sign])) != 3) {
                    continue;
                }
                $this->setWinner($sign);
                return true;
            }
        }
        return false;
    }

    private function getSignByPlayer($player): string
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
