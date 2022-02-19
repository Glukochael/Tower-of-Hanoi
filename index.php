<?php
declare(strict_types=1);


$towers = [
	[1],
	[2],
	[3],
];

$towerCheck = [1, 2, 3];


//$initialTower = readline("Откуда двигаем: ");
//$endTower = readline("Куда двигаем: ");



function isNumber(string $towerNum): bool
{
	if (is_numeric($towerNum)) {
		return true;
	}

	return false;
}

function translateCoordinate(string $towerNum): int 
{
	$towerNum = (int)$towerNum;
	$towerNum--;
	return $towerNum;
}

function isValidTower(array $towers, string $index): bool
{
	return ($index < count($towers) && $index >= 0);
}

function  accordWithRules(array $towers, $initialTower, int $endTower): bool
{
	if ($towers[$initialTower][0] > $towers[$endTower][0]) {
		return false;
	}

	return true;
}

function move(array $towers, int $initialTower, int $endTower): array 
{
	$ring = array_shift($towers[$initialTower]);
	array_unshift($towers[$endTower], $ring);

	return $towers;
}

function isGameOver(array $towers, array $towerCheck): bool
{
	return $towers === [[], [], [1, 2, 3]]
		echo "Вах, ты сложил эти Шанхай... ой то есть Ханойские башни, вай малаца, да?"
}


move($towers, 0, 1);

