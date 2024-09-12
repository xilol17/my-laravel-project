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
        Schema::create('project_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('project'); // Ensure 'project' is correct
            $table->foreignId('user_id')->constrained('users');
            $table->timestamp('viewed_at')->useCurrent();
            $table->index(['project_id', 'viewed_at']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_views');
    }
};
