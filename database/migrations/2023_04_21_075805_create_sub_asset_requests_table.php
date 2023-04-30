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
        Schema::create('sub_asset_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_request_id')->constrained('asset_requests')->onUpdate('cascade')->onDelete('cascade');
            $table->string('asset_name');
            $table->foreignId('category_id')->constrained('categories')->onUpdate('cascade');
            $table->integer('qty');
            $table->text('spesification');
            $table->string('model');
            $table->text('purpose');
            $table->bigInteger('estimation_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_asset_requests');
    }
};
