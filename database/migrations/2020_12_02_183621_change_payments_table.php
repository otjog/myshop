<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('img');
            $table->smallInteger('tax')->default(0)->after('description');
            $table->enum('tax_type', ['percent', 'value'])->after('tax');;
        });
        Schema::rename('payments', 'shop_payments');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('img', 255)->nullable();
            $table->dropColumn('tax');
            $table->dropColumn('tax_type');
        });
        Schema::rename('shop_payments', 'payments');
    }
}
