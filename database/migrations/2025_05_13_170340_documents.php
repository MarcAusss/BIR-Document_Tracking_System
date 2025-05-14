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
        Schema::create('documents', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('taxpayer_name'); // Taxpayer Name
            $table->string('taxable_period'); // Taxable Period/Year
            $table->string('docket_owner'); // Docket/Document Owner
            $table->string('document_type'); // Type of Document
            $table->enum('status', ['pending', 'draft', 'finalized'])->default('pending'); // Default status is 'pending'
            $table->string('RDO'); // RDO field
            $table->date('date_received'); // Date Received by Owner
            $table->timestamps(); // Created at and Updated at
            $table->string('recipient_office')->nullable(); // Office the document is sent to
            $table->unsignedBigInteger('recipient_user_id')->nullable(); // User the document is sent to
            $table->timestamp('time_sent')->nullable(); // Add time_sent field
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
