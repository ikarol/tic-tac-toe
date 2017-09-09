<?php
declare(strict_types = 1);
namespace Tictactoe;
use Tictactoe\Exceptions\DrawException;
use Tictactoe\Exceptions\OutOfFieldException;
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

    public function __construct(IPlayer $playerOne, IPlayer $playerTwo)
    {
        $this->playerOne = $playerOne;
        $this->playerOneSign = 'X';
        $this->playerTwo = $playerTwo;
        $this->playerTwoSign = 'O';
    }

    public function isCellEmpty(int $x, int $y): bool
    {
        if (($x < 0 || $x > 2) || ($y < 0 || $y > 2)) {
            throw new OutOfFieldException();
        }
        return in_array("$x, $y", $this->emptyBoard, true);
    }

    public function playerOneTurn(int $x, int $y)
    {
        if (!$this->isCellEmpty($x, $y)) {
            throw new CellIsNotEmptyException();
        }
        $this->registerTurn('X', "$x, $y");
    }

    public function playerTwoTurn(int $x, int $y)
    {
        if (!$this->isCellEmpty($x, $y)) {
            throw new CellIsNotEmptyException();
        }
        $this->registerTurn('O', "$x, $y");
    }

    public function startGame(): bool
    {
        return true;
    }

    public function getWinner()
    {
        return $this->winner;
    }

    private function registerTurn(string $sign, string $coordinates)
    {
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

    private function setWinner(string $sign)
    {
        $this->winner = $sign === 'X' ? $this->playerOne : $this->playerTwo;
    }

}
