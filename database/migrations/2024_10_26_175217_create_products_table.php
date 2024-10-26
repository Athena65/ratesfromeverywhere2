<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('image')->nullable(); // Ürün resmi için sütun
            $table->decimal('site_rating', 2, 1)->default(0); // Site içi değerlendirme, 0.0 - 5.0 arası
            $table->decimal('global_rating', 2, 1)->default(0); // Genel değerlendirme, 0.0 - 5.0 arası
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
