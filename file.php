<?php

declare(strict_types=1);

function drawTowers(array $towers, int $ringCount): string
{
    $spriteMap = [
        0 => "         ",
        1 => "   /|\\   ",
        2 => "  /|||\\  ",
        3 => " /|||||\\ ",
        4 => "/|||||||\\",
    ];
    $level = 0;
    $levels = [];
    while ($level < $ringCount) {
        $cx = 0;
        $r = '%s ';
        foreach ($towers as $tower) {
            $_ = array_reverse($tower);
            $idx = $ringCount - ($level + 1);
            if (isset($_[$idx])) {
                $r = sprintf($r, $spriteMap[$_[$idx]]);
            } else {
                $r = sprintf($r, $spriteMap[0]);
            }
            if ($cx < count($towers) - 1) {
                $r .= '%s ';
            }
            $cx++;
        }
        $levels[] = $r;
        $level++;
    }

    return implode("\n", $levels) . "\n";
}

function draw(array $objects): void
{
    $lines = [];
    foreach ($objects as $object) {
        $object->draw();
    }
}

class State
{
    private $ringCount = 3;
    public $towers = [];
    public function draw(): string
    {
        $spriteMap = [
            0 => "         ",
            1 => "   /|\\   ",
            2 => "  /|||\\  ",
            3 => " /|||||\\ ",
            4 => "/|||||||\\",
        ];
        $level = 0;
        $levels = [];
        while ($level < $this->ringCount) {
            $cx = 0;
            $r = '%s ';
            foreach ($this->towers as $tower) {
                $_ = array_reverse($tower);
                $idx = $this->ringCount - ($level + 1);
                if (isset($_[$idx])) {
                    $r = sprintf($r, $spriteMap[$_[$idx]]);
                } else {
                    $r = sprintf($r, $spriteMap[0]);
                }
                if ($cx < count($this->towers) - 1) {
                    $r .= '%s ';
                }
                $cx++;
            }
            $levels[] = $r;
            $level++;
        }

        return implode("\n", $levels) . "\n";
    }
}

$a = new State();
$a->draw();

echo drawTowers([[2], [1, 3], [], [4]], 4);
//echo drawTowers([[1, 2, 3], [], []], 3);
//echo drawTowers([[], [], [1, 2, 3]], 3);
//echo drawTowers([[], [1, 2, 3], []], 3);
//echo drawTowers([[], [2], [1, 3]], 3);
