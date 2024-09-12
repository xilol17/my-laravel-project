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
        Schema::create('project', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_id')->nullable()->constrained('sales')->onDelete('set null');
            $table->string('name');
            $table->date('visitDate')->nullable();
            $table->timestamp('disStartDate')->nullable();
            $table->timestamp('lastUpdateDate')->nullable();
            $table->string('turnKey');
            $table->decimal('revenue', 15, 2)->nullable();
            $table->string('BDMPM')->nullable();
            $table->string('status')->default('New Case');
            $table->string('region');
            $table->string('customerName');
            $table->string('salesName');
            $table->string('products')->nullable();
            $table->string('SI');
            $table->string('SIname')->nullable();
            $table->string('winRate')->default(0);
            $table->string('other_product')->nullable();
            $table->string('SO')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project');
    }
};
