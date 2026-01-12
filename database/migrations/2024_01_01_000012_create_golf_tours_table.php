<?php
// database/migrations/2024_01_01_000012_create_golf_tours_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('golf_tours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('itinerary')->nullable();
            $table->string('featured_image')->nullable();
            $table->json('gallery')->nullable();
            $table->integer('duration_days');
            $table->integer('duration_nights');
            $table->integer('rounds_of_golf');
            $table->decimal('price_from', 10, 2);
            $table->integer('min_participants')->default(1);
            $table->integer('max_participants')->default(20);
            $table->json('included_courses')->nullable(); // [course_id, course_id]
            $table->json('inclusions')->nullable(); // accommodation, meals, etc
            $table->json('exclusions')->nullable();
            $table->enum('difficulty_level', ['beginner', 'intermediate', 'advanced', 'all_levels'])->default('all_levels');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('reviews_count')->default(0);
            $table->date('available_from')->nullable();
            $table->date('available_to')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('golf_tours');
    }
};