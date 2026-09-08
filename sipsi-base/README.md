

Install NPM package
```bash
npm install
```

Install php package (required php 8.3)
```bash
composer install
```

(make sure this work first) Connect to postgres.
```bash
psql -U shaflyh(your user) -d postgres
```
That means:
- User shaflyh exists(or any of your user name)
- Database postgres exists
- Port 5432 is working

If not yet made the role/user
```SQL
-- Step 1: Create the `postgres` user (if it doesn't exist)
CREATE ROLE postgres WITH LOGIN PASSWORD 'qwerty123' SUPERUSER;

-- Step 2: Create the `kip` database and assign to `postgres` user
CREATE DATABASE kip OWNER postgres;
```

Migrate db
```bash
php artisan migrate
```

Seed the DB with sample data:
```bash
php artisan migrate:fresh --seed
```

Start the frontend dev server (Vite):
```bash
npm run dev
```

And in the new terminal:
```bash
php artisan serve
```


Note:
Jika error saat create sengketa:
Perlu isntall libre office:
brew install --cask libreoffice