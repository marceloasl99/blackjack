# ♠ Blackjack Club

A modern, responsive Blackjack game built with **HTML5, CSS3, vanilla JavaScript, and an optional PHP file-storage backend**.

Play against the dealer, manage a virtual bankroll, place bets, and compete on either a **local browser leaderboard** or a **shared leaderboard stored in `data.txt`** when the project is hosted on a PHP-enabled server.

> **Experimental and educational project.** The game uses virtual credits only. It does not involve real money, deposits, withdrawals, prizes, or gambling services.

## 🎮 Live Demo

**[Play Blackjack Club on GitHub Pages](https://marceloasl99.github.io/blackjack/)**

On GitHub Pages, the game works in local-storage mode because GitHub Pages does not execute PHP. Each browser therefore keeps its own local leaderboard.

## ✨ Features

- Casino-inspired responsive interface
- Welcome page with game description and basic rules
- Starting balance of **$10,000** in virtual credits
- Minimum bet of **$100**
- Betting chips for **$100**, **$500**, **$1,000**, and **$5,000**
- Standard Blackjack payout of **3:2**
- Standard wins pay **1:1**
- Pushes return the original bet
- Dealer automatically draws until reaching at least 17
- Correct Ace handling as either 1 or 11
- Hidden dealer card during the player's turn
- Detection of Blackjack, bust, win, loss, and push
- Automatic session ending when the balance is below the minimum bet
- Option to restart with a new **$10,000** session
- Duplicate names receive suffixes such as `(1)`, `(2)`, and `(3)`
- Local leaderboard with browser persistence
- Optional shared `data.txt` leaderboard through PHP
- Automatic local fallback when the PHP backend is unavailable
- Animated cards and touch-friendly controls
- Keyboard shortcuts
- No frontend framework, package manager, or build process required

## 🕹️ How to Play

1. Enter a player name on the welcome screen.
2. Start with **$10,000** in virtual credits.
3. Select one or more betting chips.
4. Click **Deal Cards**.
5. Choose an action:
   - **Hit** — draw another card.
   - **Stand** — keep the current hand and let the dealer play.
6. Try to finish closer to 21 than the dealer without going over.

### Objective

The player wins by:

- Having a hand closer to 21 than the dealer;
- Getting 21 with the first two cards, called **Blackjack**;
- Or staying at 21 or below while the dealer goes over 21.

If the player's hand exceeds 21, the player busts and loses the round.

## 💰 Betting and Payouts

| Result | Payout |
|---|---:|
| Blackjack | 3:2 |
| Standard win | 1:1 |
| Push | Original bet returned |
| Loss or bust | Bet lost |

All balances and bets are simulated credits with no monetary value.

## ⌨️ Keyboard Shortcuts

| Key | Action |
|---|---|
| `D` | Deal cards |
| `H` | Hit |
| `S` | Stand |

## 💾 Storage Modes

The project uses a generic automatic storage configuration in `index.html`:

```javascript
const STORAGE_CONFIG = {
  mode: "auto",
  apiBaseUrl: "."
};
```

### `auto` mode — recommended

- Always keeps browser storage available as a fallback;
- Detects whether `get-scores.php` is available;
- Uses the shared PHP/`data.txt` leaderboard when possible;
- Continues working locally if PHP is unavailable.

### `local` mode

To force browser-only storage:

```javascript
const STORAGE_CONFIG = {
  mode: "local",
  apiBaseUrl: "."
};
```

This mode works on GitHub Pages, static hosting, and when opening the project locally. Rankings are specific to each browser and device.

### `server` mode

To require the PHP backend:

```javascript
const STORAGE_CONFIG = {
  mode: "server",
  apiBaseUrl: "."
};
```

Use this mode only when `save-score.php`, `get-scores.php`, and writable persistent storage are available.

## 🌐 Hosting Compatibility

| Environment | Game | Local leaderboard | Shared `data.txt` leaderboard |
|---|---:|---:|---:|
| GitHub Pages | ✅ | ✅ | ❌ |
| Static hosting | ✅ | ✅ | ❌ |
| Open `index.html` locally | ✅ | ✅ | ❌ |
| Traditional PHP hosting | ✅ | ✅ | ✅ |
| VPS with PHP and persistent disk | ✅ | ✅ | ✅ |
| Serverless host with temporary filesystem | ✅ | ✅ | Not recommended |

GitHub Pages serves static files and does not execute the PHP endpoints. The `data.txt` file can be stored in the repository, but it cannot be updated by visitors on GitHub Pages.

## 📁 Project Structure

```text
blackjack/
├── index.html          # Complete game and automatic storage client
├── save-score.php      # Validates and appends completed sessions
├── get-scores.php      # Reads, sorts, and returns the leaderboard
├── data.txt            # One JSON score object per line
├── INSTALL.txt         # Short deployment instructions
├── README.md           # Project documentation
└── old_blackjack.html  # Optional previous version kept for reference
```

## 🚀 Deploying on GitHub Pages

Upload at least these files:

```text
index.html
README.md
```

You may also keep the PHP and data files in the repository for future migration:

```text
save-score.php
get-scores.php
data.txt
INSTALL.txt
```

GitHub Pages will ignore the PHP functionality and the game will automatically use browser storage.

### GitHub Pages configuration

1. Open the repository on GitHub.
2. Go to **Settings → Pages**.
3. Under **Build and deployment**, select:
   - **Source:** Deploy from a branch
   - **Branch:** `main`
   - **Folder:** `/ (root)`
4. Save the configuration.
5. Wait for the deployment to finish.

The project will be available at:

```text
https://marceloasl99.github.io/blackjack/
```

## 🐘 Deploying on PHP Hosting

Requirements:

- PHP 8.0 or newer;
- Persistent disk storage;
- Permission for the PHP process to write to `data.txt`;
- All application files in the same public directory.

Example:

```text
public_html/
├── index.html
├── save-score.php
├── get-scores.php
├── data.txt
├── README.md
└── INSTALL.txt
```

A common permission for `data.txt` is:

```text
664
```

The exact permission depends on the hosting provider and ownership configuration. Avoid `777` except for short tests in an isolated environment.

### Backend test

Open:

```text
https://your-domain.example/get-scores.php?ping=1
```

Expected response:

```json
{
  "success": true,
  "storage": "data.txt"
}
```

When this endpoint is available, `auto` mode uses the shared leaderboard.

## 🗃️ `data.txt` Format

The file uses JSON Lines: one complete JSON object per line.

Example:

```json
{"session_id":"550e8400-e29b-41d4-a716-446655440000","name":"Player","balance":12400,"wins":5,"losses":2,"draws":1,"created_at":"2026-07-12T18:30:00Z"}
```

The PHP backend:

- Validates incoming values;
- Uses an exclusive file lock while writing;
- Prevents duplicate saves using `session_id`;
- Returns the top 100 scores;
- Sorts primarily by balance and then by wins.

## 🔌 PHP API

### Read scores

```http
GET /get-scores.php
```

### Test availability

```http
GET /get-scores.php?ping=1
```

### Save a completed session

```http
POST /save-score.php
Content-Type: application/json
```

Example body:

```json
{
  "session_id": "550e8400-e29b-41d4-a716-446655440000",
  "name": "Player",
  "balance": 12400,
  "wins": 5,
  "losses": 2,
  "draws": 1
}
```

## 🔒 Security and Limitations

This file-based backend is suitable for an experimental project, demonstration, or low-traffic private deployment. It is not appropriate for real-money or trusted competitive use.

Important limitations:

- Scores originate in the browser and can be manipulated;
- `data.txt` can grow indefinitely unless it is periodically archived;
- A public endpoint may receive automated or abusive submissions;
- File locking reduces simultaneous-write issues but is not a replacement for a database;
- Some serverless hosts use temporary filesystems and may erase `data.txt`;
- Publicly serving `data.txt` exposes its complete contents.

For a production leaderboard, use server-side game validation, rate limiting, authentication, and a database.

## 🧠 Game Logic

The game uses a standard 52-card deck with four suits and thirteen ranks.

Card values:

- Number cards use their displayed value;
- Jack, Queen, and King are worth 10;
- Ace is worth 11 when possible, or 1 when 11 would cause a bust.

The dealer continues drawing while the dealer's hand value is below 17.

## 🧱 Technology Stack

- **HTML5** — semantic page structure
- **CSS3** — responsive design, cards, animations, and casino interface
- **Vanilla JavaScript** — gameplay, state, betting, sessions, and storage fallback
- **LocalStorage API** — local browser persistence
- **PHP** — optional score read/write endpoints
- **JSON Lines** — experimental file-based leaderboard storage
- **GitHub Pages** — static demo hosting

## 🧪 Running Locally

### Static/local mode

Open `index.html` directly in a modern browser. The game will use local browser storage.

### Testing the PHP backend locally

From the project directory, run:

```bash
php -S 127.0.0.1:8000
```

Then open:

```text
http://127.0.0.1:8000/
```

The built-in PHP server is intended for development and testing, not production use.

## 🛠️ Possible Future Improvements

- Database-backed shared leaderboard
- Rate limiting and anti-abuse controls
- Server-side score validation
- Double Down action
- Split pairs
- Insurance
- Multiple-deck modes
- Sound effects and mute controls
- Round history and statistics
- Progressive Web App support
- Automated game-rule tests

## 🤝 Contributing

Contributions, bug reports, and improvement suggestions are welcome.

1. Fork the repository.
2. Create a feature branch.
3. Commit the changes.
4. Push the branch.
5. Open a Pull Request.

## 📄 License

No license file is currently included. Until a license is added, the project remains under default copyright rules.

If public reuse and contribution are intended, consider adding a license such as the MIT License.

---

Built as a lightweight experimental browser project for demonstrating responsive UI design, Blackjack rules, JavaScript state management, local persistence, PHP endpoints, and file-based storage.
