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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('image_url')->nullable(); // URL veya yüklenen dosya yolu
            $table->string('status')->default('pending'); // Talep durumu: pending, approved, rejected
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Kullanıcı bilgisi
            $table->text('description')->nullable(); // Talep açıklaması
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
        Schema::dropIfExists('requests');
    }
};
