<?php
use PHPUnit\Framework\TestCase;
use Tictactoe\Gameplay;
use Tictactoe\HumanPlayer;
use Tictactoe\ComputerPlayer;

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
}
