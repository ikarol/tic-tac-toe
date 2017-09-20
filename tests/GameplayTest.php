<?php
use PHPUnit\Framework\TestCase;
use Tictactoe\Gameplay;
use Tictactoe\Players\HumanPlayer;
use Tictactoe\Players\DeterministicComputerPlayer;
use Tictactoe\Exceptions\CellIsNotEmptyException;
use Tictactoe\Exceptions\OutOfFieldException;
use Tictactoe\Exceptions\DrawException;
use Tictactoe\Cell;

final class GameplayTest extends TestCase
{
    /**
     * @test
     */
    public function on_human_wins()
    {
        $human = new HumanPlayer();
        $computer = new DeterministicComputerPlayer();
        $game = new Gameplay($human, $computer);
        $this->assertEquals(true, $game->startGame());
        $human->makeTurn(new Cell(1, 1));
        $this->assertEquals(false, $game->isCellEmpty(new Cell(1, 1)));
        $computer->makeTurn(new Cell(2, 1));
        $human->makeTurn(new Cell(1, 0));
        $computer->makeTurn(new Cell(2, 0));
        $human->makeTurn(new Cell(1, 2));
        $this->assertEquals($human, $game->getWinner());
    }

    /**
     * @test
     */
    public function on_non_empty_cell_click()
    {
        $human = new HumanPlayer();
        $computer = new DeterministicComputerPlayer();
        $game = new Gameplay($human, $computer);
        $this->assertEquals(true, $game->startGame());
        $human->makeTurn(new Cell(0, 2));
        $this->assertEquals(false, $game->isCellEmpty(new Cell(0, 2)));
        $this->expectException(CellIsNotEmptyException::class);
        $computer->makeTurn(new Cell(0, 2));
    }

    /**
     * @test
     */
    public function on_out_of_field()
    {
        $human = new HumanPlayer();
        $computer = new DeterministicComputerPlayer();
        $game = new Gameplay($human, $computer);
        $this->assertEquals(true, $game->startGame());
        $this->expectException(OutOfFieldException::class);
        $human->makeTurn(new Cell(3, 5));
    }

    /**
     * @test
     */
    public function on_draw()
    {
        $human = new HumanPlayer();
        $computer = new DeterministicComputerPlayer();
        $game = new Gameplay($human, $computer);
        $this->assertEquals(true, $game->startGame());
        $human->makeTurn(new Cell(0, 0));
        $computer->makeTurn(new Cell(0, 1));
        $human->makeTurn(new Cell(1, 1));
        $computer->makeTurn(new Cell(0, 2));
        $human->makeTurn(new Cell(1, 2));
        $computer->makeTurn(new Cell(1, 0));
        $human->makeTurn(new Cell(2, 0));
        $computer->makeTurn(new Cell(2, 2));
        $this->expectException(DrawException::class);
        $human->makeTurn(new Cell(2, 1));
    }

}
