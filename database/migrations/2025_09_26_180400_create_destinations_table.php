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
            $table->text('description')->nullable();
            $table->text('short_description')->nullable(); // คำอธิบายสั้นสำหรับแสดงในรายการ

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
            $table->integer('min_booking_days')->nullable(); // จำนวนวันขั้นต่ำในการจอง
            $table->integer('advance_booking_days')->nullable(); // ต้องจองล่วงหน้ากี่วัน

            // Capacity & Availability
            $table->integer('total_rooms')->nullable(); // จำนวนห้องทั้งหมด
            $table->integer('max_guests')->nullable(); // รับได้สูงสุดกี่คน
            $table->json('operating_hours')->nullable(); // เวลาทำการ {"open": "08:00", "close": "20:00"}
            $table->json('closed_days')->nullable(); // วันหยุด ["monday", "tuesday"]
            $table->date('opening_date')->nullable(); // วันที่เปิดให้บริการ
            $table->date('temporary_closed_from')->nullable(); // ปิดชั่วคราวตั้งแต่
            $table->date('temporary_closed_to')->nullable(); // ปิดชั่วคราวถึง

            // Ratings & Reviews
            $table->decimal('average_rating', 3, 2)->default(0.00); // คะแนนเฉลี่ย 0.00-5.00
            $table->integer('total_reviews')->default(0); // จำนวนรีวิวทั้งหมด
            $table->integer('total_bookings')->default(0); // จำนวนการจองทั้งหมด
            $table->integer('view_count')->default(0); // จำนวนการเข้าชม
            $table->integer('favorite_count')->default(0); // จำนวนคนที่บันทึกเป็นที่ชอบ

            // Verification & Quality
            $table->boolean('is_verified')->default(false); // ยืนยันตัวตนแล้ว
            $table->timestamp('verified_at')->nullable(); // วันที่ยืนยัน
            $table->foreignId('verified_by')->nullable()->constrained('admins'); // ยืนยันโดย admin คนไหน
            $table->json('certifications')->nullable(); // ใบรับรองต่างๆ
            $table->json('awards')->nullable(); // รางวัลที่ได้รับ

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
            $table->boolean('wheelchair_accessible')->default(false); // รองรับผู้พิการ
            $table->boolean('family_friendly')->default(false); // เหมาะสำหรับครอบครัว
            $table->boolean('eco_friendly')->default(false); // เป็นมิตรกับสิ่งแวดล้อม

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
            $table->softDeletes(); // เพิ่ม soft delete
        });

        // เพิ่ม indexes สำหรับ performance
        Schema::table('destinations', function (Blueprint $table) {
            $table->index('province_id');
            $table->index('slug');
            $table->index('is_active');
            $table->index('is_featured');
            $table->index('is_verified');
            $table->index('average_rating');
            $table->index('published_at');
            $table->index(['is_active', 'is_featured', 'sort_order']); // composite index
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
