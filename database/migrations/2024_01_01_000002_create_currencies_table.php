<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('code', 3)->unique();
            $table->string('name', 100);
            $table->string('symbol', 10);
            $table->decimal('exchange_rate', 10, 4)->default(1);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false);
            $table->string('format', 50)->default('{symbol}{amount}');
            $table->integer('decimal_places')->default(2);
            $table->string('phone')->nullable();
            $table->string('type')->default('customer');
            $table->string('status')->default('active');
            $table->string('avatar')->nullable();
            $table->string('preferred_language')->default('en');
            $table->string('preferred_currency')->default('usd');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('currencies');
    }
};
