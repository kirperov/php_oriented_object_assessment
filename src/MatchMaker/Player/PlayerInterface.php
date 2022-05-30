<?php

declare(strict_types=1);

namespace App\MatchMaker\Player;
interface PlayerInterface
{
    public function getName(): string;
    public function updateRatioAgainst(self $player, int $result): void;
    public function getRatio(): ?float;
}