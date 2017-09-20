<?php
declare(strict_types = 1);
namespace Tictactoe;
use Tictactoe\Exceptions\OutOfFieldException;

class Cell
{
    private $x;
    private $y;

    public function __construct(int $x, int $y)
    {
        if (($x < 0 || $x > 2) || ($y < 0 || $y > 2)) {
            throw new OutOfFieldException();
        }
        $this->x = $x;
        $this->y = $y;
    }

    public function getCoordinates(): array
    {
        return [$this->x, $this->y];
    }

    public function __toString(): string
    {
        return "{$this->x}, {$this->y}";
    }
}
