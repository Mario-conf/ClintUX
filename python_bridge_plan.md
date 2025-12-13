## System Bridge Architecture

### Concept

Laravel needs to call Python scripts to get data/perform actions.
We will use `Symfony\Component\Process\Process` to execute `python3 server_scripts/script.py`.

### Components

#### 1. `app/Services/PythonBridge.php`

-   `run(string $script, array $args = []): array`
-   Handles execution, JSON decoding, and error handling.

#### 2. `app/Services/SystemHealth.php`

-   Wraps `PythonBridge` to call `monitor.py`.
-   Returns DTO or array with stats.

#### 3. `app/Services/DockerService.php`

-   Wraps `PythonBridge` to call `docker_manager.py`.

#### 4. `app/Http/Controllers/DashboardController.php`

-   Injects services.
-   Passes data to View.

### Authentication

-   Use default `LoginController`?
-   Modify `web.php` to group everything under `auth` middleware.
