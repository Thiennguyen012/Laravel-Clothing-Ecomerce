# Hướng dẫn setup Laravel E-commerce với Docker

## Các lệnh cần chạy theo thứ tự:

# 1. Build và khởi động containers

docker-compose up -d --build

# 2. Đợi MySQL khởi động (khoảng 30 giây)

# Kiểm tra status containers

docker-compose ps

# 3. Chạy database migrations

docker-compose exec php php artisan migrate --force

# 4. Seed dữ liệu mẫu (sản phẩm, categories, etc.)

docker-compose exec php php artisan db:seed

# 5. Tạo symbolic link cho storage (để hiển thị hình ảnh)

docker-compose exec php php artisan storage:link

# 6. Clear cache

docker-compose exec php php artisan cache:clear

# 7. Set quyền cho storage

docker-compose exec php chmod -R 755 storage/app/public

# Kiểm tra ứng dụng tại: http://localhost

## Ports được sử dụng:

-   Web: http://localhost (port 80)
-   MySQL: localhost:3307
-   Database credentials: user=laravel, password=hehehe

## Troubleshooting:

# Nếu containers không start được:

docker-compose down -v
docker-compose up -d --build

# Nếu có lỗi database connection:

docker-compose logs mysql
docker-compose exec mysql mysql -u laravel -phehehe laravel -e "SHOW TABLES;"

# Nếu hình ảnh không hiển thị:

docker-compose exec php php artisan storage:link
docker-compose exec nginx nginx -s reload

# Stop tất cả containers:

docker-compose down

# Xóa volumes (reset database):

docker-compose down -v
