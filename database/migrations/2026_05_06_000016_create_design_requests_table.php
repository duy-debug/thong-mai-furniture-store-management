<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('design_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnUpdate()->nullOnDelete();
            $table->foreignId('assigned_staff_id')->nullable()->constrained('users')->nullOnUpdate()->nullOnDelete();
            $table->string('request_code')->unique();
            $table->string('customer_name');
            $table->string('customer_phone', 20);
            $table->string('customer_email')->nullable();
            $table->string('space_address');
            $table->enum('space_type', [
                'living_room',
                'bedroom',
                'kitchen',
                'whole_house',
                'office',
                'cafe',
                'apartment',
                'other',
            ]);
            $table->decimal('space_area', 10, 2)->nullable();
            $table->decimal('ceiling_height', 10, 2)->nullable();
            $table->unsignedSmallInteger('room_count')->nullable();
            $table->string('style_preference')->nullable();
            $table->string('main_color')->nullable();
            $table->decimal('budget_amount', 15, 2)->nullable();
            $table->date('desired_completion_date')->nullable();
            $table->text('requirements')->nullable();
            $table->enum('status', [
                'new',
                'contacting',
                'surveyed',
                'designing',
                'sent_design',
                'approved',
                'constructing',
                'completed',
                'cancelled',
            ])->default('new');
            $table->text('cancel_reason')->nullable();
            $table->timestamp('contacted_at')->nullable();
            $table->timestamp('surveyed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'status', 'space_type']);
            $table->index(['customer_phone', 'customer_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('design_requests');
    }
};
