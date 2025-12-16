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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('registered_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('constituency_id')->constrained()->onDelete('restrict');

            // Member details
            $table->string('full_name');
            $table->string('phone_number')->unique();
            $table->string('id_number');
            $table->enum('gender', ['Male', 'Female', 'Prefer not to say']);
            $table->string('polling_station');
            $table->string('ward');

            // Verification
            $table->string('verification_proof_path');
            $table->boolean('is_verified')->default(true);
            $table->timestamp('verified_at')->nullable();

            // GPS Coordinates (optional)
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // Registration metadata
            $table->ipAddress('registration_ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('synced_at')->nullable(); // For offline sync tracking

            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance and duplicate detection
            $table->index('phone_number');
            $table->index('company_id');
            $table->index('registered_by');
            $table->index('constituency_id');
            $table->index(['created_at', 'company_id']); // For reports
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
