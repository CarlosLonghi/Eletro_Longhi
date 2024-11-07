<?php

use App\Models\Brand;
use App\Models\Category;
use App\Models\Device;
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
        Schema::create('services', function (Blueprint $table) {
            $table->id();

            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone');

            $table->foreignIdFor(Brand::class, 'brand_id');
            $table->string('device_model');
            $table->json('device_accessories')->nullable();
            $table->string('device_description')->nullable();
            $table->json('device_images')->nullable();
            $table->foreignIdFor(Category::class, 'category_id');

            $table->decimal('price', 10, 2);
            $table->string('status')->default('awaiting_evaluation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
