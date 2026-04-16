<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                    ->constrained()
                    ->cascadeOnDelete();

            $table->string('tag');
            $table->string('name');
            $table->string('breed')->nullable();
            $table->integer('age')->default(0);
            $table->decimal('weight', 5, 2)->default(0);

            $table->enum('health', ['Healthy', 'Monitoring', 'Sick'])
                  ->default('Healthy');

            $table->date('last_checkup');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cows');
    }
};
