<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_role')->after('email_verified_at')->comment('admin, user');
            $table->string('phone_no')->after('user_role')->default('user')->nullable();
            $table->boolean('is_notification_enabled')->after('phone_no')->default(1)->comment('1= enabled, 0 = disabled');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('user_role');
            $table->dropColumn('phone_no');
            $table->dropColumn('is_notification_enabled');
        });
    }
}
