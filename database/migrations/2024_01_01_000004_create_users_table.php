<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// database/migrations/2024_01_01_000004_create_users_table.php
return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone', 20)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('type', ['customer', 'vendor', 'admin'])->default('customer');
            $table->enum('status', ['active', 'inactive', 'banned'])->default('active');
            $table->string('avatar')->nullable();
            $table->string('preferred_language', 10)->default('en');
            $table->string('preferred_currency', 3)->default('usd');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};