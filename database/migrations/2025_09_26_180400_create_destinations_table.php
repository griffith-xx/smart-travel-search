<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->foreignId('province_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('name_en')->nullable();
            $table->text('short_description')->nullable(); // คำอธิบายสั้นสำหรับแสดงในรายการ
            $table->text('description')->nullable();

            // Location & Contact
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('address')->nullable();
            $table->string('district')->nullable(); // อำเภอ
            $table->string('subdistrict')->nullable(); // ตำบล
            $table->string('postal_code', 10)->nullable(); // รหัสไปรษณีย์
            $table->string('phone')->nullable(); // เบอร์โทรศัพท์
            $table->string('email')->nullable(); // อีเมล
            $table->string('website')->nullable(); // เว็บไซต์
            $table->string('line_id')->nullable(); // LINE ID
            $table->string('facebook')->nullable(); // Facebook page
            $table->string('instagram')->nullable(); // Instagram

            // Media
            $table->text('cover_image')->nullable();
            $table->json('gallery_images')->nullable();
            $table->string('video_url')->nullable(); // YouTube/Vimeo URL
            $table->string('virtual_tour_url')->nullable(); // 360° virtual tour

            // Pricing & Booking
            $table->decimal('price_from', 10, 2)->nullable();
            $table->decimal('price_to', 10, 2)->nullable();
            $table->string('currency', 3)->default('THB'); // สกุลเงิน
            $table->text('pricing_note')->nullable(); // หมายเหตุราคา เช่น "ราคาต่อคืน" "รวมอาหาร"
            $table->boolean('accepts_online_booking')->default(false); // รับจองออนไลน์
            $table->string('booking_url')->nullable(); // URL สำหรับจอง

            // Ratings & Reviews
            $table->decimal('average_rating', 3, 2)->default(0.00); // คะแนนเฉลี่ย 0.00-5.00
            $table->integer('total_reviews')->default(0); // จำนวนรีวิวทั้งหมด
            $table->integer('total_bookings')->default(0); // จำนวนการจองทั้งหมด
            $table->integer('view_count')->default(0); // จำนวนการเข้าชม
            $table->integer('favorite_count')->default(0); // จำนวนคนที่บันทึกเป็นที่ชอบ

            // SEO & Marketing
            $table->string('meta_title')->nullable(); // SEO title
            $table->text('meta_description')->nullable(); // SEO description
            $table->json('meta_keywords')->nullable(); // SEO keywords
            $table->string('og_image')->nullable(); // Open Graph image สำหรับ social media

            // Special Features
            $table->boolean('has_parking')->default(false); // มีที่จอดรถ
            $table->boolean('has_wifi')->default(false); // มี WiFi
            $table->boolean('has_restaurant')->default(false); // มีร้านอาหาร
            $table->boolean('pet_friendly')->default(false); // รับสัตว์เลี้ยง

            // Admin & Status
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_recommended')->default(false); // แนะนำโดยทีมงาน
            $table->integer('sort_order')->default(0);
            $table->text('admin_notes')->nullable(); // หมายเหตุสำหรับ admin
            $table->timestamp('published_at')->nullable(); // วันที่เผยแพร่
            $table->foreignId('created_by')->nullable()->constrained('admins'); // สร้างโดย
            $table->foreignId('updated_by')->nullable()->constrained('admins'); // แก้ไขล่าสุดโดย

            $table->timestamps();
            $table->softDeletes();
        });

        // เพิ่ม indexes สำหรับ performance
        Schema::table('destinations', function (Blueprint $table) {
            $table->index('province_id');
            $table->index('slug');
            $table->index('is_active');
            $table->index('is_featured');
            $table->index('average_rating');
            $table->index('published_at');
            $table->index(['is_active', 'is_featured', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
