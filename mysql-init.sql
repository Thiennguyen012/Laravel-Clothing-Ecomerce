-- Create database if not exists
CREATE DATABASE IF NOT EXISTS laravel;

-- Grant all privileges to laravel user for laravel database
GRANT ALL PRIVILEGES ON laravel.* TO 'laravel'@'%';

-- Ensure root can also access the database
GRANT ALL PRIVILEGES ON laravel.* TO 'root'@'%';

-- Apply the changes
FLUSH PRIVILEGES;
