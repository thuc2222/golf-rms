<?php
// database/migrations/2024_01_01_000013_create_translations_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('translatable_type');
            $table->unsignedBigInteger('translatable_id');
            $table->string('language_code', 10);
            $table->string('field', 100);
            $table->text('value')->nullable();
            $table->timestamps();
            
            $table->index(['translatable_type', 'translatable_id']);
            $table->unique(['translatable_type', 'translatable_id', 'language_code', 'field'], 'translations_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('translations');
    }
};