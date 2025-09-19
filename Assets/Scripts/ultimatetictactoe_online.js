const xClass = 'x';
const oClass = 'o';
const xBoardWinClass = 'win_x';
const oBoardWinClass = 'win_o';
const boardDrawClass = 'draw';
const boardActiveClass = 'board_active';
const boardDisabledClass = 'board_disabled';
const cellDisabledClass = 'cell_disabled';

const startGameButton = document.getElementById('start_game_button');
const createGameButton = document.getElementById('create_game_button');
const joinGameButton = document.getElementById('join_game_button');
const inviteButton = document.getElementById('invite_button');

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
const gameInviteDialogElement = document.getElementById('game_invite_dialog');

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
let gameFinishedDialogOpen = false;


function startGame() {
    if (ultimateGameBoardElement.style.display !== "grid" && gameBoardElements[0].style.display !== "grid") {
        ultimateGameBoardElement.style.display = "grid";
        gameBoardElements.forEach(board => {
            board.style.display = "grid";
        });
        createGameButton.disabled = true;
        createGameButton.innerText = "Game already created.";
        createGameButton.style.display = "none";
        joinGameButton.disabled = true;
        joinGameButton.innerText = "Game in Progress...";
        joinGameButton.style.display = "none";

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

    // Multiplayer syncing
    updateLocalGameState();

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

    gameState = {};
    saveGameState(gameState);

    console.log("Game board reset.");

    startGame();
}


function handleClick(event) {
    if (!isMyTurn()) return;

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
        setBoardHoverClass();
        swapMark();
        updateBoardAvailability();
    }

    // Multiplayer syncing
    updateLocalGameState();
    saveGameState(gameState);
}


function setBoardHoverClass() {
    if (!isMyTurn()) return;

    ultimateGameBoardElement.classList.remove(xClass, oClass);
    if (xTurn) {
        ultimateGameBoardElement.classList.add(xClass);
    } else {
        ultimateGameBoardElement.classList.add(oClass);
    }
    console.log("Updated boardHoverClass.");
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
            //console.log("FOREACH CHECK 1: Updated board availability for board at index " + index + " to active.");
        } else if (
            !isNextBoardAvailable &&
            !board.classList.contains('win_' + xClass) &&
            !board.classList.contains('win_' + oClass) &&
            !board.classList.contains(boardDrawClass)
        ) {
            board.classList.remove(boardDisabledClass);
            board.classList.add(boardActiveClass);
            //console.log("FOREACH CHECK 2: Updated board availability for board at index " + index + " to active.");
        } else {
            board.classList.add(boardDisabledClass);
            board.classList.remove(boardActiveClass);
            //console.log("FOREACH CHECK 3: Updated board availability for board at index " + index + " to disabled.");
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
    gameFinishedDialogOpen = true;
    console.log("The game has ended: " + gameFinishedTextElement.innerText);

    // if (gameStateInterval !== null) {
    //     clearInterval(gameStateInterval);
    //     gameStateInterval = null;
    // }
}


createGameButton.addEventListener('click', createGame, { once: true });
joinGameButton.addEventListener('click', joinGame, { once: true });


let gameState = {};
let gameStateInterval = null;

const ultimatetictactoe_create_game_url = '../../php/uttt_create_game.php';
const ultimatetictactoe_join_game_url = '../../php/uttt_join_game.php';
const ultimatetictactoe_game_state_url = '../../php/uttt_game_state.php';


function createGame() {
    fetch(ultimatetictactoe_create_game_url)
        .then(response => {
            if (response.ok) return response.json();
            throw new Error(response.status + ' ' + response.statusText);
        })
        .then(data => {
            if (data.status === 'success') {
                sessionStorage.setItem('gameID', data.game_id);
                console.log(data.status_message, "Game ID: " + data.game_id);
                joinGame();
                // gameInviteDialogElement.showModal();
            } else if (data.status === 'error') {
                console.error('Error while creating a new game: ' + data.status_message);
            } else {
                console.error('Unexpected response while creating a new game.');
            }
        })
        .catch(error => {
            console.error(error);
        });
}


function getGameIDfromURL() {
    const searchParams = new URLSearchParams(window.location.search);

    if (searchParams.has("gameID")) {
        sessionStorage.setItem('gameID', searchParams.get('gameID'));
        console.log("Found URL game ID: " + searchParams.get("gameID"));
        return searchParams.get('gameID');
    } else {
        console.log('No game ID found in URL.');
        return false;
    }
}


function joinGame() {
    const gameID = sessionStorage.getItem('gameID') ? sessionStorage.getItem('gameID') : getGameIDfromURL();
    if (gameID === false) {
        console.error("No valid game ID found.");
        return;
    }
    console.log("Attempting to join the game with ID: " + gameID);

    fetch(ultimatetictactoe_join_game_url + `?gameID=${encodeURIComponent(gameID)}`)
        .then(response => {
            if (response.ok) return response.json();
            throw new Error(response.status + ' ' + response.statusText);
        })
        .then(data => {
            if (data.user_mark === xClass || data.user_mark === oClass) {
                sessionStorage.setItem('userMark', data.user_mark);
                console.log(data.status_message);
                startGame();
                startFetchingGameState();
                gameInviteDialogElement.close();
            } else if (data.user_mark === 'Spectator') {
                console.log(data.status_message);
                startGame();
                startFetchingGameState();
                gameInviteDialogElement.close();
            } else if (data.status === 'error') {
                console.error('Error while joining the game: ' + data.status_message);
                return;
            } else {
                console.error('Unexpected response while joining the game.');
                return;
            }
        })
        .catch(error => {
            console.error(error);
        });
}


function isMyTurn() {
    const userMark = sessionStorage.getItem('userMark');
    console.log("TEST mymark: " + userMark);
    return (xTurn && userMark === xClass) || (!xTurn && userMark === oClass);
}


function fetchGameState() {
    const gameID = sessionStorage.getItem('gameID');
    const userMark = sessionStorage.getItem('userMark');

    return fetch(`../../php/uttt_game_state.php?gameID=${encodeURIComponent(gameID)}&userMark=${encodeURIComponent(userMark)}`)
        .then(response => {
            if (response.ok) return response.json();
            throw new Error(response.status + ' ' + response.statusText);
        });
}


function startFetchingGameState() {
    if (gameStateInterval !== null) return;

    gameStateInterval = setInterval(() => {
        fetchGameState().then(gameState => {
            if (gameState && gameState.cells) {
                syncGameState(gameState);
            } else if (gameState && gameState.status === 'error') {
                console.log(gameState.status_message);
            } else {
                console.log('Unexpected response while fetching game state.');
            }
        })
            .catch(error => {
                console.error(error);
            });
    }, 1000);
}


function syncGameState(gameState) {
    cellElements.forEach((cell, index) => cell.className = gameState.cells[index]);
    gameBoardElements.forEach((board, index) => board.className = gameState.boards[index]);
    xTurn = gameState.xTurn;
    nextBoardIndex = gameState.nextBoardIndex;
    gameFinishedDialogOpen = gameState.gameFinishedDialogOpen;
    xScore = gameState.xScore;
    oScore = gameState.oScore;
    if (!gameFinishedDialogOpen && gameFinishedDialogElement.open) {
        gameFinishedDialogElement.close();
        gameFinishedDialogOpen = false;
    }
    if (gameFinishedDialogOpen && !gameFinishedDialogElement.open) {
        gameFinishedDialogElement.showModal();
        gameFinishedDialogOpen = true;
    }
    if (isMyTurn()) {
        setBoardHoverClass();
    }
    updateBoardAvailability();
    console.log("Updated board availability in syncGameState().");
}


function updateLocalGameState() {
    gameState = {
        cells: Array.from(cellElements).map(cell => cell.className),
        boards: Array.from(gameBoardElements).map(board => board.className),
        xTurn,
        nextBoardIndex,
        gameFinishedDialogOpen,
        xScore,
        oScore
    };
}


function saveGameState(gameState) {
    const gameID = sessionStorage.getItem('gameID');

    fetch(ultimatetictactoe_game_state_url + `?gameID=${encodeURIComponent(gameID)}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(gameState)
    });
}



// const searchInput = document.getElementById('invite_search_input');
// const suggestionsList = document.getElementById('invite_suggestions');
// let selectedUser = null;

// searchInput.addEventListener('input', () => {
//     const searchTerm = searchInput.value.trim();
//     if (searchTerm.length < 3) {
//         suggestionsList.innerHTML = '';
//         inviteButton.disabled = true;
//         selectedUser = null;
//         return;
//     }
//     fetch(`../../php/uttt_search_users.php?searchTerm=${encodeURIComponent(searchTerm)}`)
//         .then(response => response.json())
//         .then(users => {
//             suggestionsList.innerHTML = '';
//             users.forEach(user => {
//                 const li = document.createElement('li');
//                 li.textContent = user.user_username;
//                 li.onclick = () => {
//                     searchInput.value = user.user_username;
//                     selectedUser = user;
//                     suggestionsList.innerHTML = '';
//                     inviteButton.disabled = false;
//                 };
//                 suggestionsList.appendChild(li);
//             });
//             inviteButton.disabled = true;
//             selectedUser = null;
//         });
// });

// searchInput.addEventListener('blur', () => {
//     setTimeout(() => suggestionsList.innerHTML = '', 100);
// });

// inviteButton.addEventListener('click', () => {
//     if (!selectedUser) return;
//     fetch(`../../php/uttt_invite_user.php?invitee_id=${encodeURIComponent(selectedUser.user_id)}&invitee_username=${encodeURIComponent(selectedUser.user_username)}&gameID=${encodeURIComponent(gameID)}`)
//         .then(response => response.json())
//         .then(data => {
//             document.getElementById('invite_message').textContent = data.status_message || "Invite sent!";
//         })
//         .catch(() => {
//             document.getElementById('invite_message').textContent = "Failed to send invite.";
//         });
// });