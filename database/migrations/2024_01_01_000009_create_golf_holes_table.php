<?php
// database/migrations/2024_01_01_000009_create_golf_holes_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('golf_holes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('golf_course_id')->constrained()->onDelete('cascade');
            $table->integer('hole_number');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->integer('par');
            $table->json('yardage')->nullable(); // {championship: 420, regular: 380, forward: 320}
            $table->json('coordinates')->nullable(); // {x: 100, y: 200} for interactive map
            $table->string('image')->nullable();
            $table->integer('handicap')->nullable();
            $table->json('hazards')->nullable(); // [bunker, water, etc]
            $table->text('tips')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('golf_holes');
    }
};