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
        // Create users table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 100);
            $table->string('prenom', 100);
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->enum('role', ['enseignant', 'etudiant','admin'])->default('etudiant');
            $table->timestamps(); // This creates created_at and updated_at
        });

        // Create qcm table
        Schema::create('qcm', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 200);
            $table->text('description')->nullable();
            $table->foreignId('enseignant_id')->constrained('users');
            $table->timestamps();
        });

        // Create questions table
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('qcm_id')->constrained('qcm')->onDelete('cascade');
            $table->text('question');
            $table->timestamps();
        });

        // Create reponses table
        Schema::create('reponses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            $table->text('reponse');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });

        // Create resultats table
        Schema::create('resultats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('qcm_id')->constrained('qcm');
            $table->foreignId('etudiant_id')->constrained('users');
            $table->integer('score')->default(0);
            $table->integer('total_questions')->default(0);
            $table->integer('completed_at')->nullable(); // Changed from int to timestamp
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop tables in reverse order to respect foreign key constraints
        Schema::dropIfExists('resultats');
        Schema::dropIfExists('reponses');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('qcm');
        Schema::dropIfExists('users');
    }
};