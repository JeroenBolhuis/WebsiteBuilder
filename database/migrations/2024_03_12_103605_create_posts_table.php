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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->string('name')->default('Het Koppel');
            $table->string('email')->nullable();


            $table->string('title');
            $table->string('slug')->unique();
            $table->boolean('isActive');

            $table->text('description')->nullable();
            
            $table->boolean('isSent')->default(false);
            $table->boolean('isAccepted')->default(true);

            $table->foreignId('post_category_id')->nullable()->constrained('post_categories')->onDelete('set null');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
