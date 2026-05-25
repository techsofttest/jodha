<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_addresses', function (Blueprint $table) {
            if (!Schema::hasColumn('customer_addresses', 'first_name')) {
                $table->string('first_name')->nullable()->after('name');
            }
            if (!Schema::hasColumn('customer_addresses', 'last_name')) {
                $table->string('last_name')->nullable()->after('first_name');
            }
            if (!Schema::hasColumn('customer_addresses', 'email')) {
                $table->string('email')->nullable()->after('last_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_addresses', function (Blueprint $table) {
            if (Schema::hasColumn('customer_addresses', 'email')) {
                $table->dropColumn('email');
            }
            if (Schema::hasColumn('customer_addresses', 'last_name')) {
                $table->dropColumn('last_name');
            }
            if (Schema::hasColumn('customer_addresses', 'first_name')) {
                $table->dropColumn('first_name');
            }
        });
    }
};
