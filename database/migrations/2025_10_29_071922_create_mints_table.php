<?php

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
        Schema::create('mints', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('nft_id');
            $table->integer('token_id');
            $table->string('contract_address');
            $table->string('wallet_address');
            $table->string('mint_price');
            $table->string('transaction_hash')->unique()->nullable();
            $table->enum('status', ['pending', 'mint'])->default('pending');
            $table->date('date');
            $table->string('time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mints');
    }
};
