# 🚀 CodeSandbox WordPress Starter Kit

**Automated. Flexible. Dockerized.**

This is a "plug-and-play" template for running WordPress inside CodeSandbox. It is designed for developers who need to spin up a fresh WordPress test site instantly with specific versions of PHP and WordPress.

## 🌟 Why use this template?
*   **Instant Setup:** Installs WordPress automatically (skips the 5-minute setup wizard).
*   **Version Control:** Easily switch between old and new versions of WordPress or PHP.
*   **Site Health Fixed:** Pre-configured to solve common "SSL" and "Upload Limit" errors in CodeSandbox.
*   **Persistent Data:** Your plugins, themes, and database content are saved automatically, even if the server restarts.

---

## 🏁 Quick Start (How to run it)

Follow these steps exactly to avoid errors.

### 1. Create the Devbox
Click "Use this template" in GitHub or import this repository into CodeSandbox.

### 2. Configure & Secure (Crucial Step!)
**STOP.** Before you run any commands, open the `.env` file. You must configure these 3 areas now, because changing them later is difficult or impossible.

**A. Set Your Versions (The most important part)**
Decide what environment you need for your test.
*   `WP_VERSION`: Set a specific number (e.g., `6.7`, `6.2`). **WARNING: Never use "latest".**
*   `PHP_VERSION`: Set the version you need (e.g., `php8.2`, `php8.0`, `php7.4`).

**B. Set Your Security (Prevent hacking)**
The default file has weak passwords. Change them now.
*   `DB_PASSWORD`: Change this to a random string.
    *   *Example:* `DB_PASSWORD=xK9#mP2$vL5`
*   Change the `admin` username to something unique.
*   Change the `123` password to something strong.

**C. Set Project Details**
*   `WP_PORT`: Ensure this is `8001` or higher (CodeSandbox blocks port 80).
*   `PROJECT_NAME`: This becomes your Site Title.

### 3. Build and Start
Open the terminal in CodeSandbox and run this command. It tells Docker to download the versions you chose in Step 2 and build the server.

```bash
docker compose up -d --build
```

### 4. Run the Installer
Once the text stops moving in the terminal, run this script. It will set up the database and create your user.

```bash
sh install.sh
```

### 5. Preview
*   Look for the **Preview** tab.
*   Your site should load automatically.
*   **Login URL:** `/wp-admin`
*   **Login:** Use the credentials you set in Step 2.

---

## ⚙️ Configuration (The `.env` file)

| Variable | Default | Description |
| :--- | :--- | :--- |
| `PROJECT_NAME` | `my-wp-starter` | The title of your website. |
| `WP_VERSION` | `6.7` | **Required.** The specific version number. |
| `PHP_VERSION` | `php8.2` | The PHP version. |
| `WP_PORT` | `8001` | The port the site runs on. **Keep above 1024.** |
| `DB_PASSWORD` | `secret` | **Change this** before the first build. |

### ❓ Can I change settings later?

*   **Can I change the PHP_VERSION?**
    **YES.** Change it in `.env`, then run `docker compose up -d --build`.
*   **Can I change the DB_PASSWORD?**
    **NO.** This is baked into the database on the first run. If you change it later, the site will crash. You would need to delete the site and start fresh.

---

## 🔌 Managing Your Site (What is Safe?)

Since this is a Docker environment, you need to know where it is safe to make changes.

### ✅ Safe: Inside the WordPress Dashboard (GUI)
You can freely use the WordPress Dashboard (the website interface) to:
*   Install Plugins & Themes.
*   Upload Images (Media Library).
*   Create Posts & Pages.
*   Change General Settings (Site Title, Permalinks).
*   **Result:** All these changes are saved to the database or the `wp-content` folder and remain safe.

### 📂 Safe-ish: The CodeSandbox File Editor
In the file explorer on the left, you will notice you only see the `wp-content` folder. **This is intentional.**

1.  **Where are the other files?**
    *   Folders like `wp-admin`, `wp-includes`, and files like `wp-config.php` are hidden safely inside the Docker container.
    *   This protects the site core from being accidentally broken.
2.  **`wp-content/` (Your Work Area):**
    *   This folder is mapped to your file explorer.
    *   You **SHOULD** work here if you are developing a custom theme or plugin.
    *   **Warning:** Be careful not to delete standard folders inside here (like `uploads`) or the site might break.

### ❌ FORBIDDEN: Updating Core via Dashboard
**NEVER** click the "Update WordPress" button inside the Dashboard.
*   *Why?* It conflicts with your Docker settings.
*   *Correct Way:* Update `WP_VERSION` in `.env` and rebuild.

---

## 💤 Going Offline, Restarts & Data Safety

### Will my site stay online if I close the tab?
**NO.** CodeSandbox Devboxes are "Development Environments."
*   When you close the CodeSandbox tab, the server will **hibernate** (sleep).
*   The website will go offline.

### How do I turn it back on?
1.  Open your CodeSandbox project.
2.  If the site isn't loading, type: `docker compose up -d`.
3.  **Your Data is Safe:** All your posts, plugins, and database entries are stored in "Docker Volumes." They will reappear exactly as you left them.

---

## 💰 CodeSandbox Credits & Usage

Running a Devbox consumes **VM Credits** (Virtual Machine Credits).

### 1. How Credits Work
*   CodeSandbox Free Tier gives you a limited number of hours/credits per month.
*   As long as this Devbox is **Running** (the tab is open and Docker is active), you are using credits.
*   If you run out of credits, your site will shut down and you cannot restart it until the next month (or until you upgrade).

### 2. How to Save Credits
Don't leave the tab open if you aren't working!
1.  **Stop the Server:** When you are done working, type this in the terminal:
    ```bash
    docker compose stop
    ```
2.  **Close the Tab:** This ensures the VM shuts down completely.

---

## 🔄 How to Change Versions (Upgrade/Downgrade)

### Scenario A: Changing PHP Version
*Goal: You want to test if your plugin works on PHP 8.0.*
1.  Open `.env` -> Change `PHP_VERSION=php8.0`.
2.  Run: `docker compose up -d --build`
3.  **Done!** Safe to do anytime.

### Scenario B: Changing WordPress Version
*Goal: You want to test a fresh install of a different WP version.*
**Note:** Downgrading a database (e.g. 6.7 to 6.0) usually crashes the site. It is best to start fresh.

1.  Open `.env` -> Change `WP_VERSION=6.0`.
2.  **Destroy the old site:**
    ```bash
    docker compose down -v
    ```
    *(The `-v` flag deletes the old database and files so you can start clean).*
3.  **Build & Install:**
    ```bash
    docker compose up -d --build
    sh install.sh
    ```

---

## 🛠 Tools Included

*   **WP-CLI:** Run commands like `docker compose run --rm wpcli wp plugin install woocommerce`.
*   **MailHog (Email Testing):** Open port **8025** in the preview to see test emails.
*   **PHPMyAdmin:** Open port **8080** in the preview to manage the database.

---
## FAQs

**Q: Site Health says "Page cache is not detected".**

**A:** This is normal. We do not include a caching plugin by default because caching interferes with development (it hides your changes). You should only install a caching plugin when you are ready to simulate a production environment.

*Happy Coding!*