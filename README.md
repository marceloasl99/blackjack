# ♠ Blackjack Club

A modern, responsive Blackjack game built with **HTML5, CSS3, and vanilla JavaScript**. Play against the dealer, manage a virtual bankroll, place bets, and compete on a browser-based local leaderboard.

> **For entertainment and educational purposes only.** This project uses virtual credits and does not involve real money, deposits, withdrawals, or prizes.

## 🎮 Play Online

**[Open Blackjack Club](https://marceloasl99.github.io/blackjack/)**

No installation or account is required. Open the link in a modern browser, enter a player name, and start playing.

## ✨ Features

- Modern casino-inspired interface
- Fully responsive layout for desktop, tablet, and mobile
- Starting balance of **$10,000** in virtual credits
- Minimum bet of **$100**
- Betting chips for **$100**, **$500**, **$1,000**, and **$5,000**
- Standard Blackjack payout of **3:2**
- Standard wins pay **1:1**
- Pushes return the original bet
- Dealer automatically draws until reaching at least 17
- Correct Ace handling as either 1 or 11
- Hidden dealer card during the player's turn
- Automatic detection of Blackjack, bust, win, loss, and push
- Automatic session ending when the balance is below the minimum bet
- Local leaderboard saved in the browser
- Duplicate player names receive suffixes such as `(1)`, `(2)`, and `(3)`
- Animated card dealing
- Keyboard shortcuts
- No frameworks, dependencies, build tools, or backend required

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

The goal is to beat the dealer by:

- Getting a hand value closer to 21 than the dealer;
- Reaching 21 with the first two cards, called **Blackjack**;
- Or remaining at 21 or below while the dealer goes over 21.

If the player's hand exceeds 21, the player busts and loses the round.

## 💰 Betting and Payouts

| Result | Payout |
|---|---:|
| Blackjack | 3:2 |
| Standard win | 1:1 |
| Push | Bet returned |
| Loss or bust | Bet lost |

All balances and bets are simulated virtual credits with no monetary value.

## ⌨️ Keyboard Shortcuts

| Key | Action |
|---|---|
| `D` | Deal cards |
| `H` | Hit |
| `S` | Stand |

## 🏆 Leaderboard and Data Storage

The leaderboard uses the browser's `localStorage` feature.

This means:

- Results remain available after refreshing or reopening the page;
- Previously completed player sessions remain in the local ranking;
- Duplicate names are preserved as new entries using suffixes;
- Ranking data is specific to the current browser and device;
- Clearing browser data removes the locally saved leaderboard;
- Players using different devices do not share the same ranking.

### Why not `data.txt`?

GitHub Pages provides static hosting. Code running in a visitor's browser can read files from the repository, but it cannot securely modify or append results to a repository file such as `data.txt`.

A shared global leaderboard would require an external backend or database, such as Supabase, Firebase, Cloudflare D1, or a custom API.

## 🧱 Technology Stack

- **HTML5** — semantic page structure
- **CSS3** — responsive layout, card design, animations, and casino-style interface
- **Vanilla JavaScript** — game rules, state management, betting, sessions, and leaderboard
- **LocalStorage API** — persistent local player results
- **GitHub Pages** — static website hosting

## 📁 Project Structure

```text
blackjack/
├── index.html          # Complete game application
├── README.md           # Project documentation
├── old_blackjack.html  # Previous version kept for reference
└── data.txt            # Not used for live score persistence
```

The complete application is contained in `index.html`, which makes the project easy to run and deploy.

## 🚀 Running Locally

No installation is required.

1. Download or clone the repository:

```bash
git clone https://github.com/marceloasl99/blackjack.git
```

2. Open the project directory:

```bash
cd blackjack
```

3. Open `index.html` in a modern web browser.

You can also download only `index.html` and open it directly.

## 🌐 Deploying with GitHub Pages

1. Upload `index.html` to the root of the repository.
2. Open the repository on GitHub.
3. Go to **Settings → Pages**.
4. Under **Build and deployment**, select:
   - **Source:** Deploy from a branch
   - **Branch:** `main`
   - **Folder:** `/ (root)`
5. Save the configuration.
6. Wait for GitHub Pages to publish the site.

The project will be available at:

```text
https://marceloasl99.github.io/blackjack/
```

## 🧠 Game Logic

The game uses a standard 52-card deck with four suits and thirteen ranks.

Card values:

- Number cards use their displayed value;
- Jack, Queen, and King are worth 10;
- Ace is worth 11 when possible, or 1 when 11 would cause a bust.

The dealer keeps drawing cards while the dealer's hand value is below 17.

## 🔒 Privacy

- No personal account is created;
- No information is sent to a server by the game;
- Player names and results stay in the current browser;
- The project does not collect payment or financial information;
- The player can remove saved data by clearing the browser's site storage.

Players should avoid entering sensitive or personally identifiable information as a player name.

## 🛠️ Possible Future Improvements

- Shared online leaderboard using a database
- Double Down action
- Split pairs
- Insurance
- Multiple deck modes
- Sound effects with a mute control
- Round history and statistics dashboard
- Progressive Web App support
- Automated tests for game rules
- Optional difficulty and table-rule settings

## 🤝 Contributing

Contributions, bug reports, and improvement suggestions are welcome.

1. Fork the repository.
2. Create a feature branch:

```bash
git checkout -b feature/my-improvement
```

3. Commit the changes:

```bash
git commit -m "Add my improvement"
```

4. Push the branch:

```bash
git push origin feature/my-improvement
```

5. Open a Pull Request.

## 📄 License

No license file is currently included in this repository. Until a license is added, the source code remains under the default copyright rules.

If the project is intended for public reuse or contribution, consider adding a license such as the MIT License.

---

Built as a lightweight, dependency-free browser project for learning and demonstrating HTML, CSS, JavaScript, responsive design, state management, and game logic.
