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
            $table->string('member_id')->unique();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->string('gender');
            $table->string('marital_status')->nullable();
            $table->string('phone_number');
            $table->string('email')->nullable();
            $table->text('residential_address')->nullable();
            $table->date('baptism_date')->nullable();
            $table->string('membership_class')->default('Baptized');
            $table->string('membership_status')->default('Active');
            $table->string('department_ministry')->nullable();
            $table->timestamps();
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
