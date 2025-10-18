# LEPP Stack Example

Minimal LEPP stack (Linux, Engine, PostgreSQL, PHP) - sends random numbers from frontend through PHP to PostgreSQL.

## Quick Start

```bash
docker compose up --build
```

Open http://localhost:8080

## Stop

```bash
docker compose down       # Stop
docker compose down -v    # Stop and remove database
```

## Stack

- PHP built-in server (single process)
- PostgreSQL 15
- Vanilla HTML/JS frontend
- No styling, no error handling
