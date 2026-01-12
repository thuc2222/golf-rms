<?php
// database/migrations/2024_01_01_000010_create_tee_times_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tee_times', function (Blueprint $table) {
            $table->id();
            $table->foreignId('golf_course_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->time('time');
            $table->integer('available_slots')->default(4);
            $table->integer('booked_slots')->default(0);
            $table->decimal('price', 10, 2);
            $table->decimal('weekend_price', 10, 2)->nullable();
            $table->json('pricing_rules')->nullable(); // dynamic pricing
            $table->boolean('is_available')->default(true);
            $table->string('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['golf_course_id', 'date', 'time']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tee_times');
    }
};