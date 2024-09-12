<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jogo da Velha Online</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .x-icon { color: #ff5722; font-size: 4rem; font-weight: bold; }
    .o-icon { color: #03a9f4; font-size: 4rem; font-weight: bold; }
  </style>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
  <div class="bg-white p-8 rounded-lg shadow-lg">
    <h1 class="text-2xl font-bold mb-4 text-center">Jogo da Velha Online</h1>
    
    <div class="grid grid-cols-3 gap-4 mb-4" id="board">
      <div class="cell w-24 h-24 flex justify-center items-center text-3xl border cursor-pointer" data-index="0"></div>
      <div class="cell w-24 h-24 flex justify-center items-center text-3xl border cursor-pointer" data-index="1"></div>
      <div class="cell w-24 h-24 flex justify-center items-center text-3xl border cursor-pointer" data-index="2"></div>
      <div class="cell w-24 h-24 flex justify-center items-center text-3xl border cursor-pointer" data-index="3"></div>
      <div class="cell w-24 h-24 flex justify-center items-center text-3xl border cursor-pointer" data-index="4"></div>
      <div class="cell w-24 h-24 flex justify-center items-center text-3xl border cursor-pointer" data-index="5"></div>
      <div class="cell w-24 h-24 flex justify-center items-center text-3xl border cursor-pointer" data-index="6"></div>
      <div class="cell w-24 h-24 flex justify-center items-center text-3xl border cursor-pointer" data-index="7"></div>
      <div class="cell w-24 h-24 flex justify-center items-center text-3xl border cursor-pointer" data-index="8"></div>
    </div>

    <!-- Pontuação -->
    <div class="flex justify-between items-center mb-4">
      <div class="text-xl font-semibold">X: <span id="scoreX">0</span> ⭐</div>
      <div class="text-xl font-semibold">O: <span id="scoreO">0</span> ⭐</div>
    </div>

    <!-- Cronômetro -->
    <div class="text-center text-lg mb-4">Tempo de Rodada: <span id="timer">00:00</span></div>

    <div id="message" class="text-center font-bold text-lg mb-4"></div>
    <button id="restartBtn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Reiniciar Jogo</button>
  </div>

  <script>
    const cells = document.querySelectorAll('.cell');
    const message = document.getElementById('message');
    const restartBtn = document.getElementById('restartBtn');
    const scoreXEl = document.getElementById('scoreX');
    const scoreOEl = document.getElementById('scoreO');
    const timerEl = document.getElementById('timer');

    let currentPlayer = 'X';
    let board = ['', '', '', '', '', '', '', '', ''];
    let scoreX = 0;
    let scoreO = 0;
    let timer = 0;
    let intervalId;

    const winPatterns = [
      [0, 1, 2], [3, 4, 5], [6, 7, 8],
      [0, 3, 6], [1, 4, 7], [2, 5, 8],
      [0, 4, 8], [2, 4, 6]
    ];

    // Verifica se há um vencedor ou empate
    function checkWinner() {
    for (const pattern of winPatterns) {
        const [a, b, c] = pattern;
        if (board[a] && board[a] === board[b] && board[a] === board[c]) {
        return board[a]; // Retorna "X" ou "O" em caso de vitória
        }
    }
    if (board.includes('')) {
        return null; // Jogo ainda não terminou
    }
    return 'Empate'; // Se não houver espaços vazios, retorna "Empate"
    }
    // Formata o cronômetro para 00:00 (minutos:segundos)
    function formatTime(seconds) {
      const minutes = Math.floor(seconds / 60);
      const secs = seconds % 60;
      return `${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
    }

    // Inicia o cronômetro
    function startTimer() {
      clearInterval(intervalId);
      timer = 0;
      timerEl.textContent = formatTime(timer);
      intervalId = setInterval(() => {
        timer++;
        timerEl.textContent = formatTime(timer);
        if (timer >= 60) {
          clearInterval(intervalId);
          message.textContent = "Tempo Esgotado!";
          setTimeout(restartGame, 2000); // Reinicia o jogo após 2 segundos
        }
      }, 1000);
    }

    // Reinicia o jogo
    function restartGame() {
      board.fill('');
      currentPlayer = 'X';
      cells.forEach(cell => cell.textContent = '');
      message.textContent = 'É a vez de X';
      startTimer();
    }

    // Exibe o vencedor ou empate
    function handleClick(e) {
    const index = e.target.dataset.index;
    if (board[index] || checkWinner()) return;

    board[index] = currentPlayer;
    e.target.innerHTML = currentPlayer === 'X' ? `<span class="x-icon">X</span>` : `<span class="o-icon">O</span>`;
    const winner = checkWinner();

    if (winner) {
        clearInterval(intervalId);
        if (winner === 'X') {
        scoreX++;
        scoreXEl.textContent = scoreX;
        message.textContent = `X venceu!`;
        } else if (winner === 'O') {
        scoreO++;
        scoreOEl.textContent = scoreO;
        message.textContent = `O venceu!`;
        } else if (winner === 'Empate') {
        message.textContent = 'Empate!';
        }
        return;
    }

    currentPlayer = currentPlayer === 'X' ? 'O' : 'X';
    message.textContent = `É a vez de ${currentPlayer}`;
    }

    // Eventos
    cells.forEach(cell => cell.addEventListener('click', handleClick));
    restartBtn.addEventListener('click', restartGame);

    // Inicializa o jogo
    restartGame();
  </script>
</body>
</html>
