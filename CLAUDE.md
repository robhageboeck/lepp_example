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
- **src/index.html**: Frontend with 1 button
- **src/query.php**: Backend with 1 action (insert)
- **init.sql**: Creates random_numbers table and loads seed.csv
- **seed.csv**: Sample data loaded on startup

## API

POST /query.php:
- `{"action": "insert", "number": 123}` - Insert number, returns `{"id": 1, "number": 123}`

## Database

Table: `random_numbers` (id, number, created_at)
Seeded with 10 rows from seed.csv on first startup

## Modifying the Table Schema

To add/modify columns:

1. **Edit init.sql** - Modify CREATE TABLE statement
2. **Edit seed.csv** - Add/remove columns (first row is header)
3. **Edit init.sql** - Update COPY command column list if needed
4. **Edit src/query.php** - Update queries to use new columns
5. **Rebuild**: `docker compose down -v && docker compose up --build`

Example - adding a "category" column:
```sql
-- init.sql
CREATE TABLE random_numbers (
    id SERIAL PRIMARY KEY,
    number INTEGER,
    category VARCHAR(50),  -- NEW COLUMN
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
COPY random_numbers(number, category) FROM '/seed.csv' WITH (FORMAT csv, HEADER true);
```

```csv
# seed.csv
number,category
42,even
123,odd
```
