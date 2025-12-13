# ClintUX | System Version: v2.4.1

The ultimate centralized management interface for server infrastructure, Docker containers, and self-hosted applications. Built for simplicity, security, and premium aesthetics.

![ClintUX Cover](public/img/login-bg.png)

## Table of Contents

1.  [Features](#features)
2.  [Performance & Optimization](#performance--optimization)
3.  [Technology Stack](#technology-stack)
4.  [Architecture](#architecture)
5.  [Installation & Execution](#installation--execution)
6.  [Troubleshooting & FAQ](#troubleshooting--faq)
7.  [Developer Contact](#developer-contact)

---

## Features

-   **Real-Time Monitoring**: Live visualization of CPU, RAM, Disk, and Network usage using efficient Python bridges.
-   **Docker Management**:
    -   List running/stopped containers.
    -   Start, Stop, and Restart actions directly from the UI.
    -   Create new lightweight containers (e.g., Nginx, Alpine).
-   **Application Hub**: Centralized launcher for all your self-hosted apps (Plex, Portainer, Pi-hole, etc.) with reverse proxy support.
-   **Secure Authentication**: Role-based access control (Admin/User), audit logging, and brutal-force protection.
-   **Premium Design**:
    -   **Glassmorphism Layout**: Modern aesthetic with blur effects and transparency.
    -   **Persistent Dark Mode**: Adapts to user preference and saves state across sessions.
    -   **Spline Sans Typography**: Clean, modern readability.

## Security & User Management

To ensure maximum security for this private dashboard:

-   **Public Registration Disabled**: The `/register` route has been deactivated. New users can ONLY be created by an Admin from the "Users" panel.
-   **Manual Recovery**: The "Forgot Password" feature is disabled to prevent enumeration attacks. Password resets must be performed by an Admin.
-   **Search Engine Block**: `robots.txt` is configured to disallow all indexing (`User-agent: * Disallow: /`).

## Performance & Optimization

ClintUX is engineered for maximum speed and stability, leveraging enterprise-grade optimization techniques:

### PHP Opcache

We enabled the PHP OPcache extension in our Docker environment.

-   **What it does**: Stores precompiled script bytecode in shared memory, removing the need for PHP to load and parse scripts on every request.
-   **Impact**: drastically reduces CPU usage and response time for complex pages (up to 3x faster).

### Gzip Compression

Nginx is configured to serve compressed assets automatically.

-   **Configuration**: Aggressive compression level 6 for text, JSON, CSS, and JavaScript.
-   **Impact**: Reduces bandwidth consumption by 70-80%, ensuring near-instant page loads even on slower networks.

### Docker Stability

-   **Base Image**: Built on `php:8.3-fpm` (Debian-based) for maximum compatibility and robustness.
-   **Restart Policies**: Containers are set to `restart: unless-stopped`, ensuring high availability and automatic recovery after system reboots.

## Technology Stack

-   **Backend**: Laravel 11 (PHP 8.3+)
-   **Frontend**: Blade Templates, TailwindCSS, Alpine.js (Lightweight interactivity)
-   **System Integration**: Python 3 (psutil, docker-py)
-   **Database**: SQLite (Default) or MySQL/MariaDB
-   **Containerization**: Docker & Docker Compose

## Architecture

ClintUX follows a **Model-View-Controller (MVC)** pattern with a specialized "Bridge" layer:

1.  **Frontend (Blade/Alpine)**: Renders the UI and polls the backend for live data.
2.  **Laravel Backend**: Handles auth, routing, and business logic.
3.  **Python Bridge**:
    -   Laravel executes Python scripts via `Process`.
    -   Python scripts interacts with the Host OS (via `psutil` or `docker-py`) to fetch privileged data.
    -   Data is returned as JSON to Laravel for display.

This decoupled approach ensures the web server stays lightweight while accessing low-level system metrics securely.

## Installation & Execution

The project is designed to be "Clone & Run".

### Prerequisites

-   **Docker** and **Docker Compose** installed on the host machine.

### Quick Start

1.  **Clone the Repository**

    ```bash
    git clone https://github.com/Mario-conf/dashboard.git
    cd dashboard
    ```

2.  **Launch with Docker Compose**

    ```bash
    docker compose up -d --build
    ```

    _The system will automatically:_

    -   Build the containers with Opcache support.
    -   Install dependencies.
    -   Run database migrations.
    -   Serve the app at `http://localhost:8000`.

3.  **Access ClintUX**
    -   **URL**: `http://localhost:8000`
    -   **Default Login**:
        -   Email: `admin@example.com`
        -   Password: `password`

## Troubleshooting & FAQ

### The page isn’t redirecting properly (Redirect Loop)

**Cause**: Earlier versions had a conflict between the root path `/` and authentication middleware.
**Solution**: This was fixed in `v2.4.1` by explicitly configuring `bootstrap/app.php` to redirect authenticated users to `/clintux`. If you see this, clear your browser cookies for localhost.

### Docker permission denied

**Cause**: The user running the app inside the container usually maps to `www-data`.
**Solution**: The `docker-compose.yml` mounts the Docker socket (`/var/run/docker.sock`). Ensure your host user has permissions to run docker commands, or usage of `sudo` might be implicitly handled by the Python bridge simulation if running locally on Windows (Laragon).

### Styles look broken or generic

**Cause**: TailwindCSS build might not have run or cache is stale.
**Solution**: The Docker build process includes the necessary asset compilation. Try forcing a rebuild with `docker compose build --no-cache`.

---

## Developer Contact

<div align="center">

  <h3>Mario Conf</h3>
  <p><strong>SysAdmin & Full Stack Developer</strong></p>
  
<p>
    <a href="mailto:mario04asir@gmail.com">
      <img src="https://img.shields.io/badge/Email-mario04asir%40gmail.com-red?style=flat&logo=gmail" alt="Email">
    </a>
    <a href="https://linkedin.com/in/mario-conf">
      <img src="https://img.shields.io/badge/LinkedIn-Mario%20Acosta-blue?style=flat&logo=linkedin" alt="LinkedIn">
    </a>
  </p>

  <p>📍 <strong>Granada, Andalucía, España</strong></p>
</div>

---

_&copy; 2025 ClintUX. All rights reserved._
