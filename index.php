<?php
declare(strict_types=1);


$towers = [
	[1, 2, 3],
	[],
	[],
];

function getUserInput(array $towers): array
{
    /**
     * зачем getUsetInput что-то знает о towers?
     * а если мы больше не будем хранить состояние игры в массиве?
     * что нам после этого переписывать и эту функцию тоже?
     * твой код не должен быть похож на дорожку из домино:
     * изменение чего-то одного не должно приводить к необходимости менять что-то еще.
     * $towers у тебя тут из-за того, что ты в рамках данной функции вызываешь isValidTower.
     * Чего тут быть не должно. потому что isValidTower относится к логике игры, а не к пользовательскому вводу.
     * определение функции должно быть таким:
     * function getUserInput(): array
     * { ... }
     * никаких $towers
     */

    /**
     * что будет если ввод будет некорректным?
     * в этом случае ты запускаешь функцию CorrectUserInput.
     * Но это имеет смысл только в том случае, если ввод пользователя можно исправить.
     * что же происходит у тебя? Ты считываешь пользовательский ввод повторно в функции CorrectUserInput.
     * а значит знание о том, откуда ты получаешь ввод пользователя у тебя размазывается по двум функиям.
     * это не очень здорово. Знание о readline должно быть строго в getUserInput.
     * сделай две отдельные функции: первая пусть проверяет является ли ввод корректным и возвращает булево (А).
     * вторая пусть его корректирует. но корректировать она будет только в том случае, если ввод оказался корректным с
     * точки зрения предыдущей функции.
     **/

    /**
     * отдельный комментарий по поводу реализации.
     * мне кажется и from и to можно считать в одном цикле. грубоо говоря - не дублировать код
     */
	$from = readline("Откуда двигаем: ");
	$from = CorrectUserInput($towers, $from);
	
	$to = readline("Куда двигаем: ");
	$to = CorrectUserInput($towers, $to);

	return [$from, $to];	
}

function CorrectUserInput(array $towers, string $num): int 
{
    /**
     * это функция недоразумение
     */
	while (isNumber($num) === false) {
		$num = readline("Давай ещё раз, только теперь цифрой: ");
	}
	$num = (int)$num;
	while (isValidTower($towers, $num) === false) {
        /**
         * эта проверка относится к логике игры. она должны быть вне функции  getUserInput.
         * сейчас зависимость у тебя такая getUserInput -> CorrectUserInput -> isValidTower
         */
		$num = readline("Тебе нужно число от 1 до 3, попробуй ещё раз: ");
		$num = (int)$num;
	}

	return $num;
}

function isNumber(string $towerNum): bool
{
    /**
     * это как раз та функция A.
     * у тебя тут форматирование съехало.
     */
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
    /**
     * надо почитать тебе как работают операции инкремента и декремента.
     * они уже возвращают число.
     * то есть можно написать вот так:
     * return $towerNum--;
     */
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
    /**
     * array_unshift($towers[$to], array_shift($towers[$from]));
     */
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
        /**
         * форматирование массива очень неудочное:
         * см. sample
         */
        $sample = [
            [1, 2, 3],
            [],
            [],
        ];
		$towers = [
			[1, 2, 3],
			[],
			[],
			];
        /**
         * вопапа. этот вызов тут не уместен. Эта функция фактически запускает приложение. надо придумать как это делать иначе
         * например, функция newGame (стоит переименовать) будет возвращать истину, если пользаватель хочет продолжить игру.
         * а ты в зависимости от ее результата в главном цикле обнуляй состояние игры и запускай все по новой.
         */
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

function draw(array $towers): void
{
    $spritesMap = [
        0 => "        ",
        1 => "  /|\\  ",
        2 => " /|||\\ ",
        3 => "/|||||\\",
    ];
    $renderStruct = [];
    $level = 0;
}

function runGame(array $towers)
{
	$finalPosition = $towers[0];
	$numMove = 1;
	echo "		Х А Н О Й С К И Е   Б А Ш Н И \n Перед тобой 3 башни, от тебя требуется передвинуть башню на 3 позицию. Удачи!.\n \n";
	playImage($towers);

    /**
     * while (!isGameOver($towers, $finalPosition)) { ... }
     */
	while (isGameOver($towers, $finalPosition) === false) {
        /**
         * echo sprintf("Номер хода: %s\n", $numMove);
         * так более цивилизовано
         */
		echo "Номер хода: " . $numMove . "\n";
		$coordinates = getUserInput($towers);
        /**
         * немного непонятно зачем нужна такая логика.
         * можно сделать так, чтобы translateCoordinate принимала массив
         * и тогда будет вот так:
         * [$from, $to] = translateCoordinates(getUserInput());
         */
		$from = translateCoordinate($coordinates[0]);
		$to = translateCoordinate($coordinates[1]);

        /**
         * предлагаю переименовать accordWithRules на isValidMove
         * опять же. php позволяет тебе не проводить постоянные сравнение на истину ложь.
         * ты можешь написать так:
         * if (isValidMove($towers, $from, $to)) { ... }
         */
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


