<?php
use PHPUnit\Framework\TestCase;
use Tictactoe\Gameplay;

final class GameplayTest extends TestCase
{
    public function testOnClassInstantiation()
    {
        $game = new Gameplay();
    }
}
