<?php
declare(strict_types=1);


$towers = [
	[1, 2, 3],
	[],
	[],
];

function getUserInput(array $towers): array
{
	$from = readline("Откуда двигаем: ");
	$from = CorrectUserInput($towers, $from);
	
	$to = readline("Куда двигаем: ");
	$to = CorrectUserInput($towers, $to);

	return [$from, $to];	
}

function CorrectUserInput(array $towers, string $num): int 
{
	while (isNumber($num) === false) {
		$num = readline("Давай ещё раз, только теперь цифрой: ");
	}
	$num = (int)$num;
	while (isValidTower($towers, $num) === false) {
		$num = readline("Тебе нужно число от 1 до 3, попробуй ещё раз: ");
		$num = (int)$num;
	}

	return $num;
}

function isNumber(string $towerNum): bool
{
		if (is_numeric($towerNum)) {
		return true;
	}

	return false;
}

function isValidTower(array $towers, int $index): bool
{
	return ($index <= count($towers) && $index > 0);
}


function translateCoordinate(int $towerNum): int 
{
	$towerNum--;
	return $towerNum;
}

function  accordWithRules(array $towers, int $from, int $to): bool
{
	if (count($towers[$to]) === 0) {
		if (count($towers[$from]) != 0){
			return true;
		}
		return false;
	}

	if (count($towers[$from]) === 0) {
		return false;
	}

	if ($towers[$from][0] > $towers[$to][0]) {
		return false;
	}

	return true;
}

function move(array $towers, int $from, int $to): array 
{
	$ring = array_shift($towers[$from]);
	array_unshift($towers[$to], $ring);

	return $towers;
}

function isGameOver(array $towers, array $finalPosition): bool
{
	return $towers[count($towers) - 1] === $finalPosition;
}

function newGame(array $towers): void
{
	$newGame = readline("Игра окончена желателе сыграть ещё раз? y/n: ");
	if ($newGame === "y") {
		$towers = [
			[1, 2, 3],
			[],
			[],
			];
		runGame($towers);
	}
	elseif ($newGame === "n") {
		echo "Приходи играть снова!";
	}
}

function playImage(array $towers): void
{
	$figures = [
	1 => "  /|\\  ",
	2 => " /|||\\ ",
	3 => "/|||||\\",
	];
	$emptyPosition = "       ";
	$upLvl = "";
	$middleLvl = "";
	$downLvl = "";
	$numLvl = "   1   " . "   2   " . "   3   ";

	foreach ($towers as $tower) {
		if (count($tower) === 3) {
			$upLvl .= $figures[$tower[0]];
		}
		else {
			$upLvl .= $emptyPosition;
		}
	} 

	foreach ($towers as $tower) {
		if (count($tower) === 2) {
			$middleLvl .= $figures[$tower[0]];
		}
		elseif (count($tower) === 3) {
			$middleLvl .= $figures[$tower[1]];
		}
		else {
			$middleLvl .= $emptyPosition;
		}
	}

	foreach ($towers as $tower) {
		if (count($tower) === 1) {
			$downLvl .= $figures[$tower[0]];
		}
		elseif (count($tower) === 2) {
			$downLvl .= $figures[$tower[1]];
		}
		elseif (count($tower) === 3) {
			$downLvl .= $figures[$tower[2]];
		}
		else {
			$downLvl .= $emptyPosition;
		}
	}
	
	echo $upLvl . "\n" . $middleLvl . "\n" . $downLvl . "\n" . $numLvl . "\n";
}

function runGame(array $towers)
{
	$finalPosition = $towers[0];
	$numMove = 1;
	echo "		Х А Н О Й С К И Е   Б А Ш Н И \n Перед тобой 3 башни, от тебя требуется передвинуть башню на 3 позицию. Удачи!.\n \n";
	playImage($towers);

	while (isGameOver($towers, $finalPosition) === false) {
		echo "Номер хода: " . $numMove . "\n";
		$coordinates = getUserInput($towers);
		$from = translateCoordinate($coordinates[0]);
		$to = translateCoordinate($coordinates[1]);
		if (accordWithRules($towers, $from, $to) === true) {
			$towers = move($towers, $from, $to);
			$numMove++;
		}
		else {
			echo "Разрешено передвигать только меньший диск на больший \n";
		}
		playImage($towers);

		if ($numMove > 8) {
			echo "Ты не управился в 7 ходов. \n";
			newGame($towers);
		}
	}

	newGame($towers);
}


runGame($towers);


