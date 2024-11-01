let map;

let doneCnt = 0;

function loadMap(lat = 40.665459, long = -73.965091) {
    console.log("Loading map...");
    map = L.map('map').setView([lat, long], 2);
    L.tileLayer.provider('Esri.WorldImagery').addTo(map);
}

function getMyLocation() {
    console.log("Getting location...");
    if (!navigator.geolocation) {
        alert("I need your location permission to continue.");
    }

    navigator.geolocation.getCurrentPosition((position) => {
        const lat = position.coords.latitude;
        const long = position.coords.longitude;
        map.setView([lat, long]);
        let marker = L.marker([lat, long]).addTo(map);
        marker.bindPopup("You are here!");
    }, (positionError) => {
        console.error(positionError);
    }, {
        enableHighAccuracy: false
    });
}

function saveMap() {
    leafletImage(map, function (err, canvas) {
        let mapImage = document.getElementById("savedImage");
        let imageContext = mapImage.getContext("2d");

        imageContext.drawImage(canvas, 0, 0, 300, 150);
        const puzzles = getPuzzles();
        drawPuzzles(puzzles);
    });
}

function getPuzzles() {
    let image = document.getElementById("savedImage");

    const puzzles = [];
    const puzzleWidth = image.width / 4;
    const puzzleHeight = image.height / 4;

    let idCnt = 0;

    for (let x = 0; x < 4; x++) {
        for (let y = 0; y < 4; y++) {
            const puzzle = document.createElement("canvas");
            puzzle.width = puzzleWidth;
            puzzle.height = puzzleHeight;
            const puzzleContext = puzzle.getContext("2d");

            puzzleContext.drawImage(
                image,
                x * puzzleWidth,
                y * puzzleHeight,
                puzzleWidth,
                puzzleHeight,
                0,
                0,
                puzzleWidth,
                puzzleHeight
            );

            puzzle.id = `puzzle-${idCnt}`;
            puzzles.push(puzzle);
            idCnt++;
        }
    }
    return shuffleArray(puzzles);
}

function shuffleArray(array) {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
    return array;
}

function drawPuzzles(puzzles) {
    const container = document.getElementById("puzzleContainer");
    container.innerHTML = '';

    puzzles.forEach((puzzle) => {
        const newCanvas = document.createElement("canvas");
        newCanvas.width = puzzle.width;
        newCanvas.height = puzzle.height;
        newCanvas.className = "puzzle";
        newCanvas.id = puzzle.id;

        newCanvas.setAttribute("draggable", "true");
        newCanvas.setAttribute("ondragstart", "dragPuzzle(event)");

        newCanvas.getContext("2d").drawImage(puzzle, 0, 0, puzzle.width, puzzle.height);
        container.appendChild(newCanvas);
    });
}

function drawBoard() {
    const boardContainer = document.getElementById("boardContainer");
    boardContainer.innerHTML = '';

    const boardSize = 4;

    for (let i = 0; i < boardSize * boardSize; i++) {
        const cell = document.createElement("div");
        cell.className = "board-cell";
        cell.id = `board-cell-${i}`;

        cell.setAttribute("ondrop", "dropPuzzle(event)");
        cell.setAttribute("ondragover", "allowDrop(event)");

        boardContainer.appendChild(cell);
    }
}

function allowDrop(event) {
    event.preventDefault();
}

function dragPuzzle(event) {
    event.dataTransfer.setData("text", event.target.id);
}

function dropPuzzle(event) {
    event.preventDefault();
    const puzzleId = event.dataTransfer.getData("text");
    const puzzlePiece = document.getElementById(puzzleId);
    console.log("puzzle id: ", puzzleId);
    console.log("puzzle piece: ", puzzlePiece);
    if (puzzlePiece) {
        event.target.appendChild(puzzlePiece);
        const cellId = parseInt(event.target.id.split('-')[2], 10);
        const puzzleNumber = parseInt(puzzleId.split("-")[1], 10);

        console.log("cell id: ", cellId);
        console.log("puzzleOgId: ", puzzleNumber);
        if (cellId === puzzleNumber) {
            console.log("Puzzel na swoim miejscu!");
            event.target.style.border = "2px solid green";
            doneCnt++;
        } else {
            console.log("Puzzel nie jest na swoim miejscu.");
            event.target.style.border = "2px solid red";
        }
    }

    if (doneCnt === 16){
        alert("BRAWO!! Udało Ci się ułożyć puzzle!!");
    }
}

document.getElementById("getImage").addEventListener("click", () => {
    saveMap();
    drawBoard();
});



loadMap();

document.getElementById("getLocation").addEventListener("click", getMyLocation);
document.getElementById("getImage").addEventListener("click", saveMap);