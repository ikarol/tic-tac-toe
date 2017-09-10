<?php
declare(strict_types = 1);
use PHPUnit\Framework\TestCase;
use Tictactoe\Cell;
use Tictactoe\Gameplay;
use Tictactoe\Players\HumanPlayer;
use Tictactoe\Players\RandomizedComputerPlayer;

final class RandomizedComputerPlayerTest extends TestCase
{
    /**
     * @test
     */
    public function on_instantiation()
    {
        $computer = new RandomizedComputerPlayer();
        $this->assertInstanceOf(RandomizedComputerPlayer::class, $computer);
    }

    /**
     * @test
     */
    public function on_random_cell()
    {
        $computer = new RandomizedComputerPlayer();
        $human = new HumanPlayer();
        $game = new Gameplay($human, $computer);
        $game->startGame();
        $human->makeTurn(new Cell(1, 0));
        $computer->makeRandomizedTurn();
        $this->assertEquals(7, count($game->getEmptyBoard()));
    }
}
