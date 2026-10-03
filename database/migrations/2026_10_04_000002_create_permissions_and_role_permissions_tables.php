<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 150)->unique();
            $table->string('slug', 150)->unique();
            $table->string('module', 100);
            $table->string('action', 50);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index(['module', 'action']);
        });

        Schema::create('role_permissions', function (Blueprint $table) {
            $table->uuid('role_id');
            $table->uuid('permission_id');

            $table->primary(['role_id', 'permission_id']);

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->cascadeOnDelete();

            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
        Schema::dropIfExists('permissions');
    }
};
