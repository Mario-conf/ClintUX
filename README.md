# Laravel Dashboard 🚀

A premium, modern Dashboard for managing your home server, built with **Laravel 11** and **Tailwind CSS**.

![Dashboard Preview](https://via.placeholder.com/800x400?text=Dashboard+Preview)

## ✨ Features

-   **System Monitoring**: Real-time stats for CPU, Memory, Disk, Network, and Uptime (via Python integration).
-   **Docker Management**:
    -   List running containers.
    -   Start / Stop / Restart containers.
    -   **Portainer-like Creation Form**: Deploy new containers with ease (Image, Name, Ports, Restart Policy).
-   **App Launcher**: Manage and launch your self-hosted applications / internal tools.
-   **Secure Proxy**: Built-in reverse proxy to access internal apps securely.
-   **Role-Based Access Control (RBAC)**:
    -   **Admin**: Full access (System Control, Docker, App Management).
    -   **Dev**: Docker Management access.
    -   **User**: View-only access to allowed apps.
-   **Modern UI**: Fully responsive, Dark Mode support, Glassmorphism design.

## 🛠 Requirements

-   PHP 8.2+
-   Composer
-   Node.js & NPM
-   Python 3 (for system stats & docker control)
    -   `pip install psutil docker`
-   SQLite (default) or MySQL

## 🚀 Installation

1. **Clone the repository**

    ```bash
    git clone https://github.com/yourusername/dashboard.git
    cd dashboard
    ```

2. **Install Dependencies**

    ```bash
    composer install
    npm install && npm run build
    ```

3. **Environment Setup**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

    _Edit `.env` and set your domain:_

    ```env
    APP_DOMAIN=myserver.com
    ```

4. **Database Setup**

    ```bash
    touch database/database.sqlite
    php artisan migrate --seed
    ```

    _(The seeder creates a default Admin user: `admin@example.com` / `password`)_

5. **Python Dependencies**
   Ensure Python is discoverable in your path.

    ```bash
    pip install psutil docker
    ```

6. **Run the Server**
    ```bash
    php artisan serve
    ```

## 🔒 Security

-   **Sensitive Data**: This project uses standard Laravel `.env` for secrets. **NEVER** commit your `.env` file.
-   **Python Scripts**: The scripts in `server_scripts/` run system commands. Ensure the user running the PHP process has appropriate permissions (Docker group, etc.).

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
