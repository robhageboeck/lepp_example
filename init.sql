-- Database initialization script
--
-- To modify the table schema:
-- 1. Add/remove columns in CREATE TABLE below
-- 2. Update seed.csv to match new columns
-- 3. Update COPY command column list if needed
-- 4. Update src/query.php queries to use new columns
-- 5. Run: docker compose down -v && docker compose up --build

CREATE TABLE random_numbers (
    id SERIAL PRIMARY KEY,              -- Auto-increment ID
    number INTEGER,                     -- The random number (from CSV)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Auto-set timestamp
);

-- Load seed data from CSV
-- Format: COPY table_name(column1, column2, ...) FROM '/path' WITH (FORMAT csv, HEADER true);
COPY random_numbers(number) FROM '/seed.csv' WITH (FORMAT csv, HEADER true);
