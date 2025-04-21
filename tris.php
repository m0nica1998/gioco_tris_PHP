<?php
session_start(); // Avvia la sessione PHP per mantenere lo stato del gioco tra i vari refresh della pagina


// Inizializzazione della griglia se non esiste ancora
if (!isset($_SESSION['board'])) {
    $_SESSION['board'] = array_fill(0, 9, ''); // Crea un array di 9 elementi vuoti per rappresentare il tabellone
    $_SESSION['turn'] = 'X'; // Il primo turno è sempre del giocatore X
    $_SESSION['message'] = ''; // Nessun messaggio iniziale
    $_SESSION['game_over'] = false; // Il gioco è attivo
}

// Tutte le possibili combinazioni vincenti (righe, colonne, diagonali)
$winningCombos = [
    [0,1,2], [3,4,5], [6,7,8], // Righe
    [0,3,6], [1,4,7], [2,5,8], // Colonne
    [0,4,8], [2,4,6]           // Diagonali
];

// Se il giocatore clicca su una cella
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cell']) && !$_SESSION['game_over']) {
    $cell = intval($_POST['cell']); //converte il valore della stringa in un intero

    // Se la cella è vuota
    if ($_SESSION['board'][$cell] === '') {
        $_SESSION['board'][$cell] = $_SESSION['turn']; // Assegna la X o la O alla cella

        // Controllo vittoria
        foreach ($winningCombos as $combo) {
            if ($_SESSION['board'][$combo[0]] === $_SESSION['turn'] &&
                $_SESSION['board'][$combo[1]] === $_SESSION['turn'] &&
                $_SESSION['board'][$combo[2]] === $_SESSION['turn']) {
             // Se tutte e tre le celle nella combinazione corrispondono al turno attuale, il giocatore ha vinto
                $_SESSION['message'] = "Il giocatore {$_SESSION['turn']} ha vinto!";
                $_SESSION['game_over'] = true;
                break; // Esce dal ciclo
            }
        }

        // Controllo pareggio
        // Se nessuno ha vinto e non ci sono più celle vuote, è un pareggio
        if (!$_SESSION['game_over'] && !in_array('', $_SESSION['board'])) {
            $_SESSION['message'] = "Pareggio!";
            $_SESSION['game_over'] = true;
        }

        // Cambio turno
         // Se il gioco non è finito, si cambia turno
        if (!$_SESSION['game_over']) {
            $_SESSION['turn'] = $_SESSION['turn'] === 'X' ? 'O' : 'X';
        }
    }
}

// Reset partita
// Gestione del pulsante "Rigioca", che distrugge la sessione e ricarica la pagina
if (isset($_POST['reset'])) {
    session_destroy(); // Elimina tutte le variabili di sessione
    header("Location: tris.php"); // Ricarica la pagina per iniziare una nuova partita
    exit;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Tris in PHP</title>
    <style>
         /* Stile generale del corpo della pagina */
        body {
            text-align: center;
            font-family: sans-serif;
            padding-top: 50px;
            background-color: #f4f4f4;
        }
        /* Griglia 3x3 per il tabellone */
        .board {
            display: grid;
            grid-template-columns: repeat(3, 80px); /* 3 colonne larghe 80px */
            grid-gap: 5px; /* Spazio tra le celle */
            justify-content: center;
        }
        /* Stile di ogni cella del tabellone */
        .cell {
            width: 80px;
            height: 80px;
            background-color: #fff;
            border: 1px solid #ccc;
            font-size: 2em;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        /* Stile del bottone interno alla cella */
        .cell button {
            width: 100%;
            height: 100%;
            font-size: 2em;
            background: none;
            border: none;
            cursor: pointer;
        }
         /* Stile del messaggio di fine partita */
        .message {
            margin-top: 20px;
            font-size: 1.2em;
        }
    </style>
</head>
<body>

    <h1>Gioco del Tris (PHP)</h1>

    <!-- Form per la gestione delle mosse e del reset -->
    <form method="post">
        <div class="board">
             <!-- Cicla ogni cella del tabellone -->
            <?php foreach ($_SESSION['board'] as $index => $value): ?>
                <div class="cell">
                    <?php if ($value === '' && !$_SESSION['game_over']): ?>
                        <!-- Se la cella è vuota e la partita non è finita, mostra un bottone -->
                        <button type="submit" name="cell" value="<?= $index ?>"></button>
                    <?php else: ?>
                         <!-- Altrimenti mostra la X o la O -->
                        <?= $value ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

         <!-- Mostra il messaggio di vittoria o pareggio -->
        <div class="message"><?= $_SESSION['message'] ?></div>

         <!-- Bottone per resettare la partita -->
        <div style="margin-top: 20px;">
            <button type="submit" name="reset">Rigioca</button>
        </div>
    </form>

</body>
</html>
