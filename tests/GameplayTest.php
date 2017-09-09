<?php
use PHPUnit\Framework\TestCase;
use Tictactoe\Gameplay;
use Tictactoe\HumanPlayer;
use Tictactoe\ComputerPlayer;
use Tictactoe\Exceptions\CellIsNotEmptyException;
use Tictactoe\Exceptions\OutOfFieldException;
use Tictactoe\Exceptions\DrawException;

final class GameplayTest extends TestCase
{
    /**
     * @test
     */
    public function on_human_wins()
    {
        $human = new HumanPlayer();
        $computer = new ComputerPlayer();
        $game = new Gameplay($human, $computer);
        $this->assertEquals(true, $game->startGame());
        $game->playerOneTurn(1, 1);
        $this->assertEquals(false, $game->isCellEmpty(1, 1));
        $game->playerTwoTurn(2, 1);
        $game->playerOneTurn(1, 0);
        $game->playerTwoTurn(2, 0);
        $game->playerOneTurn(1, 2);
        $this->assertEquals($human, $game->getWinner());
    }

    /**
     * @test
     */
    public function on_non_empty_cell_click()
    {
        $human = new HumanPlayer();
        $computer = new ComputerPlayer();
        $game = new Gameplay($human, $computer);
        $this->assertEquals(true, $game->startGame());
        $game->playerOneTurn(0, 2);
        $this->assertEquals(false, $game->isCellEmpty(0, 2));
        $this->expectException(CellIsNotEmptyException::class);
        $game->playerTwoTurn(0, 2);
    }

    /**
     * @test
     */
    public function on_out_of_field()
    {
        $human = new HumanPlayer();
        $computer = new ComputerPlayer();
        $game = new Gameplay($human, $computer);
        $this->assertEquals(true, $game->startGame());
        $this->expectException(OutOfFieldException::class);
        $game->playerOneTurn(3, 5);
    }

    /**
     * @test
     */
    public function on_draw()
    {
        $human = new HumanPlayer();
        $computer = new ComputerPlayer();
        $game = new Gameplay($human, $computer);
        $this->assertEquals(true, $game->startGame());
        $game->playerOneTurn(0, 0);
        $game->playerTwoTurn(0, 1);
        $game->playerOneTurn(0, 2);
        $game->playerTwoTurn(1, 0);
        $game->playerOneTurn(1, 1);
        $game->playerOneTurn(1, 2);
        $game->playerTwoTurn(2, 1);
        $game->playerOneTurn(2, 0);
        $this->expectException(DrawException::class);
        $game->playerTwoTurn(2, 2);
    }

}
