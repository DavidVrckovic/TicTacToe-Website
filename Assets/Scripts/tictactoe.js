const xClass = 'x';
const oClass = 'o';

const startGameButton = document.getElementById('start_game_button');
const gameBoardElement = document.getElementById('game_board');
const cellElements = document.querySelectorAll('[data-game_cell]');

const gameInfoDialogElement = document.getElementById('game_info');
const currentPlayerElement = document.getElementById('current_player_mark');
let xScore = 0;
let oScore = 0;
const xScoreElement = document.getElementById('score_x');
const oScoreElement = document.getElementById('score_o');

const gameFinishedDialogElement = document.getElementById('game_finished_dialog');
const gameFinishedTextElement = document.getElementById('game_finished_message');

const restartButton = document.getElementById('restart_button');
const exitButton = document.getElementById('exit_button');

const boardWinningCombinations = [
    [0, 1, 2],
    [3, 4, 5],
    [6, 7, 8],
    [0, 3, 6],
    [1, 4, 7],
    [2, 5, 8],
    [0, 4, 8],
    [2, 4, 6]
];

let xTurn = Math.random() < 0.5;
currentPlayerElement.innerText = xTurn ? "X" : "O";
currentPlayerElement.classList.add(xTurn ? xClass : oClass);


function startGame() {
    if (gameBoardElement.style.display !== "grid") {
        gameBoardElement.style.display = "grid";
        startGameButton.disabled = true;
        startGameButton.innerText = "Game in Progress...";
        startGameButton.style.display = "none";

        gameInfoDialogElement.style.display = "flex";
        gameInfoDialogElement.show();
    }

    restartButton.addEventListener('click', resetGameBoard);
    exitButton.addEventListener('click', () => {
        window.location.href = "../../";
    });

    cellElements.forEach(cell => {
        cell.addEventListener('click', handleClick, { once: true });
    });

    setBoardHoverClass();

    console.log("The game has started!" + " Leading player: " + (xTurn ? "X" : "O"));
}


function resetGameBoard() {
    gameFinishedDialogElement.close();

    cellElements.forEach(cell => {
        cell.classList.remove(xClass, oClass);
        cell.removeEventListener('click', handleClick);
    });

    console.log("Game board reset.");

    startGame();
}


function handleClick(event) {
    const targetCell = event.target;
    const currentMarkClass = xTurn ? xClass : oClass;

    placeMark(targetCell, currentMarkClass);

    if (checkWin(currentMarkClass)) {
        endGame(false);
    } else if (checkDraw()) {
        endGame(true);
    } else {
        swapMark();
        setBoardHoverClass();
    }
}


function setBoardHoverClass() {
    gameBoardElement.classList.remove(xClass, oClass);
    if (xTurn) {
        gameBoardElement.classList.add(xClass);
    } else {
        gameBoardElement.classList.add(oClass);
    }
}


function placeMark(targetCell, currentMarkClass) {
    targetCell.classList.add(currentMarkClass);
    console.log((xTurn ? "X" : "O") + " placed.");
}


function swapMark() {
    xTurn = !xTurn;
    currentPlayerElement.innerText = xTurn ? "X" : "O";
    currentPlayerElement.classList.add(xTurn ? xClass : oClass);
    currentPlayerElement.classList.remove(!xTurn ? xClass : oClass);
    console.log("Swapped turn. Now it's " + (xTurn ? "X" : "O") + "'s turn.");
}


function checkWin(currentMarkClass) {
    return boardWinningCombinations.some(combination => {
        return combination.every(index => {
            return cellElements[index].classList.contains(currentMarkClass);
        });
    });
}


function checkDraw() {
    return [...cellElements].every(cell => {
        return cell.classList.contains(xClass) || cell.classList.contains(oClass);
    });
}


function endGame(draw) {
    if (draw) {
        gameFinishedTextElement.innerText = 'Draw!';
    } else {
        gameFinishedTextElement.innerText = `${xTurn ? "X" : "O"} has won the game!`;
        if (xTurn) {
            xScore += 1;
            xScoreElement.innerText = xScore;
        } else {
            oScore += 1;
            oScoreElement.innerText = oScore;
        }
    }
    gameFinishedDialogElement.showModal();
    console.log("The game has ended: " + gameFinishedTextElement.innerText);
}


startGameButton.addEventListener('click', startGame, { once: true });