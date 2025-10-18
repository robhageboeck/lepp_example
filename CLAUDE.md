# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Minimal LEPP Stack - sends random numbers from vanilla JS through PHP to PostgreSQL. Uses PHP built-in server. No styling, no error handling.

## Commands

```bash
docker compose up --build    # Start at http://localhost:8080
docker compose down          # Stop
docker compose down -v       # Stop and remove database
docker compose exec postgres psql -U postgres -d leppdb  # Database shell
```

## Architecture

Single process PHP built-in server in one container. PostgreSQL in separate container. Hardcoded credentials: postgres/password.

**Request Flow:**
Browser → PHP built-in server (port 80) → PostgreSQL

## Files

- **Dockerfile**: PHP 8.2 CLI with pdo_pgsql extension
- **docker-compose.yml**: 2 services (web, postgres)
- **src/index.html**: Frontend with 2 buttons
- **src/query.php**: Backend with 2 actions (insert, stats)
- **init.sql**: Creates random_numbers table

## API

POST /query.php:
- `{"action": "insert", "number": 123}` - Insert number
- `{"action": "stats"}` - Get stats and recent 10 entries

## Database

Table: `random_numbers` (id, number, created_at)
