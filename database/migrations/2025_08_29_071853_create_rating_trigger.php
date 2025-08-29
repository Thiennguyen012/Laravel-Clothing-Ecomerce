<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Trigger khi thêm rating
        DB::unprepared('
            CREATE TRIGGER after_insert_rating
            AFTER INSERT ON rating
            FOR EACH ROW
            BEGIN
                UPDATE products
                SET 
                    total_ratings = (
                        SELECT COUNT(*)
                        FROM rating r
                        JOIN variants v ON r.variant_id = v.id
                        WHERE v.product_id = (
                            SELECT product_id FROM variants WHERE id = NEW.variant_id
                        )
                    ),
                    avg_rating = (
                        SELECT COALESCE(AVG(r.star), 0)
                        FROM rating r
                        JOIN variants v ON r.variant_id = v.id
                        WHERE v.product_id = (
                            SELECT product_id FROM variants WHERE id = NEW.variant_id
                        )
                    )
                WHERE product_id = (
                    SELECT product_id FROM variants WHERE id = NEW.variant_id
                );
            END
        ');

        // Trigger khi cập nhật rating
        DB::unprepared('
            CREATE TRIGGER after_update_rating
            AFTER UPDATE ON rating
            FOR EACH ROW
            BEGIN
                UPDATE products
                SET 
                    total_ratings = (
                        SELECT COUNT(*)
                        FROM rating r
                        JOIN variants v ON r.variant_id = v.id
                        WHERE v.product_id = (
                            SELECT product_id FROM variants WHERE id = NEW.variant_id
                        )
                    ),
                    avg_rating = (
                        SELECT COALESCE(AVG(r.star), 0)
                        FROM rating r
                        JOIN variants v ON r.variant_id = v.id
                        WHERE v.product_id = (
                            SELECT product_id FROM variants WHERE id = NEW.variant_id
                        )
                    )
                WHERE product_id = (
                    SELECT product_id FROM variants WHERE id = NEW.variant_id
                );
            END
        ');

        // Trigger khi xóa rating
        DB::unprepared('
            CREATE TRIGGER after_delete_rating
            AFTER DELETE ON rating
            FOR EACH ROW
            BEGIN
                UPDATE products
                SET 
                    total_ratings = (
                        SELECT COUNT(*)
                        FROM rating r
                        JOIN variants v ON r.variant_id = v.id
                        WHERE v.product_id = (
                            SELECT product_id FROM variants WHERE id = OLD.variant_id
                        )
                    ),
                    avg_rating = (
                        SELECT COALESCE(AVG(r.star), 0)
                        FROM rating r
                        JOIN variants v ON r.variant_id = v.id
                        WHERE v.product_id = (
                            SELECT product_id FROM variants WHERE id = OLD.variant_id
                        )
                    )
                WHERE product_id = (
                    SELECT product_id FROM variants WHERE id = OLD.variant_id
                );
            END
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_insert_rating');
        DB::unprepared('DROP TRIGGER IF EXISTS after_update_rating');
        DB::unprepared('DROP TRIGGER IF EXISTS after_delete_rating');
    }
};
