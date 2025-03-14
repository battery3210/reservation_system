<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            if (!Schema::hasColumn('customers', 'password')) {
                $table->string('password')->nullable();
            }
            if (!Schema::hasColumn('customers', 'is_member')) {
                $table->boolean('is_member')->default(false);
            }
            if (!Schema::hasColumn('customers', 'remember_token')) {
                $table->rememberToken();
            }
            if (!Schema::hasColumn('customers', 'email_verified_at')) {
            $table->timestamp('email_verified_at')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            if (Schema::hasColumn('customers', 'password')) {
                $table->dropColumn('password');
            }
            if (Schema::hasColumn('customers', 'is_member')) {
                $table->dropColumn('is_member');
            }
            if (Schema::hasColumn('customers', 'remember_token')) {
                $table->dropColumn('remember_token');
            }
            if (Schema::hasColumn('customers', 'email_verified_at')) {
                $table->dropColumn('email_verified_at');
            }
        });
    }
};

