<?php
declare(strict_types=1)


$towers = [
	[1],
	[2],
	[3],
];

$towerCheck = [1, 2, 3];

$initialTower = (readline("Откуда двигаем: ") - 1);
$endTower = readline("Куда двигаем: ");



function isNumber(string $towerNum): bool
{
	if (is_numeric($towerNum)) {
		return true;
	}

	return false;
}

function translateCoordinate(string $towerNum): int 
{
	(int)$towrNum;
	$towerNum--;
	return $towerNum;
}

function checkTower(array $towers, int $towerNum): bool
{
	if ($towerNum > (count($towers[$towerNum]) - 1) || $towerNum < 0) {
		return false;
	}

	return true;
}

function  accordWithRules(array $towers, int $initialTower, int $endTower): bool
{
	if ($towers[$initialTower][0] > $towers[$endTower][0]) {
		return false;
	}

	return true;
}

function move(array $towers, int $initialTower, int $endTower): array 
{
	array_unshift($towers[endTower]) = array_shift($towers[$initialTower])

	return $towers;
}

function gameOver(array $towers, array $towerCheck): bool
{
	$lastTower = (count($towers) - 1);
	$last
	if (count($towers[$lastTower]) === count($towerCheck)) {
		echo "Вах, ты сложил эти Шанхай... ой то есть Ханойские башни, вай малаца, да?"
		return true;
	}

	return false;
}





