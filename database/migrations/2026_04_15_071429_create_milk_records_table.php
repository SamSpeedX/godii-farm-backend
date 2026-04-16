<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('milk_records', function (Blueprint $table) {
            // $table->id('id')//->primary()->default(DB::raw('gen_random_uuid()'));
            $table->bigIncrements('id');

            $table->foreignId('user_id');
            $table->foreignId('cow_id');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users') // badili kama ni auth.users
                  ->cascadeOnDelete();

            $table->foreign('cow_id')
                  ->references('id')
                  ->on('cows')
                  ->cascadeOnDelete();

            $table->date('date');
            $table->decimal('amount', 5, 2);

            $table->enum('session', ['Morning', 'Lunch', 'Evening']);

            $table->timestamps();
            // $table->timestampTz('created_at')
            //       ->default(DB::raw("TIMEZONE('utc', NOW())"));

            // $table->timestampTz('updated_at')
            //       ->default(DB::raw("TIMEZONE('utc', NOW())"));
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('milk_records');
    }
};
