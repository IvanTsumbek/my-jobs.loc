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
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_source_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('company');
            $table->longText('description')->nullable();
            $table->string('url');
            $table->string('location')->nullable();
            $table->boolean('is_remote')->default(false);
            $table->integer('salary_min')->nullable();
            $table->integer('salary_max')->nullable();
            $table->string('salary_currency')->nullable();
            $table->string('employment_type')->nullable(); // full-time, part-time, contract, freelance
            $table->string('category')->nullable();
            $table->json('tags')->nullable();
            $table->string('external_id')->nullable();
            $table->string('external_url')->nullable();
            $table->string('hash')->unique();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('fetched_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
