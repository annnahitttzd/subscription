<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        public function up(): void
        {
            Schema::create('posts', function (Blueprint $table) {
                $table->id();
                $table->integer('website_id');
                $table->foreign('website_id')->on('websites')->references('id')->cascadeOnDelete();
                $table->string('title');
                $table->text('description');
                $table->timestamps();
            });
        }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
