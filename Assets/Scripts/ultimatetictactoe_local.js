const xClass = 'x';
const oClass = 'o';
const xBoardWinClass = 'win_x';
const oBoardWinClass = 'win_o';
const boardDrawClass = 'draw';
const boardActiveClass = 'board_active';
const boardDisabledClass = 'board_disabled';
const cellDisabledClass = 'cell_disabled';

const startGameButton = document.getElementById('start_game_button');
const ultimateGameBoardElement = document.getElementById('ultimate_game_board');
const gameBoardElements = document.querySelectorAll('[data-game_board]');
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
let nextBoardIndex = null;


function startGame() {
    if (ultimateGameBoardElement.style.display !== "grid" && gameBoardElements[0].style.display !== "grid") {
        ultimateGameBoardElement.style.display = "grid";
        gameBoardElements.forEach(board => {
            board.style.display = "grid";
        });
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
    updateBoardAvailability();

    console.log("The game has started!" + " Leading player: " + (xTurn ? "X" : "O"));
}


function resetGameBoard() {
    gameFinishedDialogElement.close();

    cellElements.forEach(cell => {
        cell.classList.remove(xClass, oClass);
        cell.removeEventListener('click', handleClick);
    });

    nextBoardIndex = null;

    gameBoardElements.forEach(board => {
        board.classList.remove(xBoardWinClass, oBoardWinClass, boardDrawClass, boardActiveClass, boardDisabledClass);
        board.removeEventListener('click', handleClick);
    });

    console.log("Game board reset.");

    startGame();
}


function handleClick(event) {
    const targetCell = event.target;
    if (targetCell.closest('[data-game_board]').classList.contains(boardDisabledClass)) return;
    const currentMarkClass = xTurn ? xClass : oClass;
    const currentBoardElement = targetCell.closest('[data-game_board]');
    const currentBoardIndex = Array.from(gameBoardElements).indexOf(currentBoardElement);
    const placedMarkCellIndex = Array.from(currentBoardElement.querySelectorAll('[data-game_cell]')).indexOf(targetCell);
    nextBoardIndex = placedMarkCellIndex;
    console.log("Next board index set to " + nextBoardIndex + ".");

    placeMark(targetCell, currentMarkClass);

    if (checkBoardWin(currentBoardElement, currentMarkClass)) {
        currentBoardElement.classList.add('win_' + currentMarkClass);
        console.log((xTurn ? "X" : "O") + " has won the board at index " + currentBoardIndex + ".");
    } else if (checkBoardDraw(currentBoardElement)) {
        currentBoardElement.classList.add(boardDrawClass);
        console.log("The board at index " + currentBoardIndex + " is a draw.");
    }

    if (checkWin(currentMarkClass)) {
        endGame(false);
    } else if (checkDraw()) {
        endGame(true);
    } else {
        swapMark();
        setBoardHoverClass();
        updateBoardAvailability();
    }
}


function setBoardHoverClass() {
    ultimateGameBoardElement.classList.remove(xClass, oClass);
    if (xTurn) {
        ultimateGameBoardElement.classList.add(xClass);
    } else {
        ultimateGameBoardElement.classList.add(oClass);
    }
}


function updateBoardAvailability() {
    let isNextBoardAvailable = false;

    if (
        nextBoardIndex !== null &&
        !gameBoardElements[nextBoardIndex].classList.contains('win_' + xClass) &&
        !gameBoardElements[nextBoardIndex].classList.contains('win_' + oClass) &&
        !gameBoardElements[nextBoardIndex].classList.contains(boardDrawClass)
    ) {
        isNextBoardAvailable = true;
    }

    gameBoardElements.forEach((board, index) => {
        if (isNextBoardAvailable && index === nextBoardIndex) {
            board.classList.remove(boardDisabledClass);
            board.classList.add(boardActiveClass);
            // console.log("FOREACH CHECK 1: Updated board availability for board at index " + index + " to active.");
        } else if (
            !isNextBoardAvailable &&
            !board.classList.contains('win_' + xClass) &&
            !board.classList.contains('win_' + oClass) &&
            !board.classList.contains(boardDrawClass)
        ) {
            board.classList.remove(boardDisabledClass);
            board.classList.add(boardActiveClass);
            // console.log("FOREACH CHECK 2: Updated board availability for board at index " + index + " to active.");
        } else {
            board.classList.add(boardDisabledClass);
            board.classList.remove(boardActiveClass);
            // console.log("FOREACH CHECK 3: Updated board availability for board at index " + index + " to disabled.");
        }
    });
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
    console.log("Swapped mark. Set current player to: " + (xTurn ? "X" : "O"));
}


function checkBoardWin(currentBoardElement, currentMarkClass) {
    const currentBoardCellElements = currentBoardElement.querySelectorAll('[data-game_cell]');
    return boardWinningCombinations.some(combination => {
        return combination.every(index => {
            return currentBoardCellElements[index].classList.contains(currentMarkClass);
        });
    });
}


function checkWin(currentMarkClass) {
    return boardWinningCombinations.some(combination => {
        return combination.every(index => {
            return gameBoardElements[index].classList.contains('win_' + currentMarkClass);
        });
    });
}


function checkBoardDraw(currentBoardElement) {
    const currentBoardCellElements = currentBoardElement.querySelectorAll('[data-game_cell]');
    return [...currentBoardCellElements].every(cell => {
        return cell.classList.contains(xClass) || cell.classList.contains(oClass);
    });
}


function checkDraw() {
    return [...gameBoardElements].every(board => {
        return board.classList.contains(xBoardWinClass) || board.classList.contains(oBoardWinClass) || board.classList.contains(boardDrawClass);
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