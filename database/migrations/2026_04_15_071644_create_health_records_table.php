<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('health_records', function (Blueprint $table) {
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
            $table->string('status');
            $table->text('symptoms')->nullable();
            $table->text('treatment')->nullable();
            $table->timestamps();

            // $table->timestampTz('created_at')
            //       ->default(DB::raw("TIMEZONE('utc', NOW())"));

            // $table->timestampTz('updated_at')
            //       ->default(DB::raw("TIMEZONE('utc', NOW())"));
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('health_records');
    }
};

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration
// {
//     /**
//      * Run the migrations.
//      */
//     public function up(): void
//     {
//         Schema::create('health_records', function (Blueprint $table) {
//             $table->id();
//             $table->timestamps();
//         });
//     }

//     /**
//      * Reverse the migrations.
//      */
//     public function down(): void
//     {
//         Schema::dropIfExists('health_records');
//     }
// };
