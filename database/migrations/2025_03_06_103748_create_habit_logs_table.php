<?php

use App\Models\Habit;
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

        Schema::create('habit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Habit::class)->constrained()->cascadeOnDelete();
            $table->date('date'); // date for user
            $table->boolean('status')->nullable()->default(null);
            $table->integer('streak')->default(0);
            $table->index('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habit_logs');
    }
};
