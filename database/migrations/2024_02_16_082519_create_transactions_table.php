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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('products_id');
            $table->bigInteger('customers_id');
            $table->bigInteger('resellers_id')->nullable();
            $table->string('proof_of_payment')->nullable();
            $table->string('invois');
            $table->integer('quantity');
            $table->integer('total')->nullable();
            $table->integer('total_payment')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
