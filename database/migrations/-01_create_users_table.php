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
        Schema::create('users', function (Blueprint $table) {
            
            //primary key
            $table->id();

            //this is the user table base columns
            //note: we remove the name column for the user table and which the firstname, lastname, middlename will be the composite key
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            
            //addons for the users
            $table->string('firstname');
            $table->string('lastname');
            $table->string('middlename');
            
            //composite key not to be duplicate
            $table->unique(['firstname', 'lastname', 'middlename']);

            //personal information
            $table->string('phone')->unique();
            $table->string('gender')->default('male');
            $table->string('address');
            
            //school name
            $table->string('school');

            //student number
            $table->string('student_no')->unique();
            
            //auto generated when the user create the account
            $table->string('qr_code')->default('');
            
            //starting date
            //this is different from the timestamp(created_at) date
            $table->date('starting_date')->nullable();

            //emergency contact
            $table->string('emergency_contact_number');
            $table->string('emergency_contact_fullname');
            $table->string('emergency_contact_address');

            //hidden column
            $table->string('role')->default('user');

            //expiry for the account
            $table->date('expiry_date')->nullable();

            //status for the account
            $table->string('status')->default('active');

            //this will be the use for date for the create account
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
