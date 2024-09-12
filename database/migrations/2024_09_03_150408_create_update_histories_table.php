<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('update_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\project::class);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('attribute')->nullable();
            $table->string('title')->nullable();
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
            $table->string('update_type')->nullable();
            $table->text('file_name')->nullable();
            $table->text('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('update_histories');
    }
};
