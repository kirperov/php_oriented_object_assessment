<?php

declare(strict_types=1);
class Encounter {

    public const RESULT_WINNER = 1;
    public const RESULT_LOSER = -1;
    public const RESULT_DRAW = 0;
    public const RESULT_POSSIBILITIES = [self::RESULT_WINNER, self::RESULT_LOSER, self::RESULT_DRAW];


    public static function probabilityAgainst(int $levelPlayerOne, int $againstLevelPlayerTwo)
    {
        return 1/(1+(10 ** (($againstLevelPlayerTwo - $levelPlayerOne)/400)));
    }

    public static function setNewLevel(int &$levelPlayerOne, int $againstLevelPlayerTwo, int $playerOneResult)
    {
        if (!in_array($playerOneResult, self::RESULT_POSSIBILITIES)) {
            trigger_error(sprintf('Invalid result. Expected %s',implode(' or ', self::RESULT_POSSIBILITIES)));
        }

        $levelPlayerOne += (int) (32 * ($playerOneResult - self::probabilityAgainst($levelPlayerOne, $againstLevelPlayerTwo)));
    }
}

class Player {
    public int $level;
}


$greg = 400;
$jade = 800;

$playerOne = new Player;
$playerTwo = new Player;

$playerOne->level = $greg;
$playerTwo->level = $jade;

echo sprintf(
    'Greg à %.2f%% chance de gagner face a Jade',
    Encounter::probabilityAgainst($playerOne->level, $playerTwo->level)*100
).PHP_EOL;

// Imaginons que greg l'emporte tout de même.
Encounter::setNewLevel($playerOne->level, $playerTwo->level, Encounter::RESULT_WINNER);
Encounter::setNewLevel($playerOne->level, $playerTwo->level, Encounter::RESULT_LOSER);

echo sprintf(
    'les niveaux des joueurs ont évolués vers %s pour Greg et %s pour Jade',
    $playerOne->level,
    $playerTwo->level
);

exit(0);