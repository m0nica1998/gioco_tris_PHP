# Gioco del Tris in PHP

Questo è un semplice **gioco del Tris (Tic-Tac-Toe)** realizzato in **PHP**, con interfaccia in **HTML e CSS**.  
Il gioco funziona tramite sessioni per mantenere lo stato tra i vari click dell’utente.

---

## 🎮 Regole del Gioco

- Il tabellone è una griglia 3x3.
- Due giocatori (X e O) si alternano cliccando su una cella vuota.
- Vince chi riesce ad allineare tre simboli uguali (in orizzontale, verticale o diagonale).
- Se tutte le celle sono piene e nessuno ha vinto, è pareggio.
- Il pulsante **Rigioca** resetta la partita.

---

## ⚙️ Logica del Codice

- All'avvio, se non esiste, viene creata una sessione con:
  - `board`: array di 9 celle vuote
  - `turn`: il turno attuale (`X` o `O`)
  - `game_over`: stato della partita
  - `message`: messaggio di fine partita

- Quando si clicca su una cella:
  - Se è vuota e la partita non è finita:
    - Viene assegnato il simbolo del turno
    - Si controllano tutte le **combinazioni vincenti**
    - Se il turno ha vinto, si mostra un messaggio e la partita termina
    - Se il tabellone è pieno, è pareggio
    - Altrimenti, si passa il turno all’altro giocatore

- Se si preme **Rigioca**:
  - La sessione viene distrutta e la pagina ricaricata.

---

## 🛠️ Tecnologie

- **PHP** per la logica e la gestione dello stato
- **HTML/CSS** per la struttura e lo stile


