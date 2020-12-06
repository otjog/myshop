<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropColumn('img');
            $table->enum('type', ['toDoor', 'toTerminal'])->after('name');
            $table->tinyInteger('processing_time')->unsigned()->default(0)->after('type');
            $table->smallInteger('tax')->unsigned()->default(0)->after('type');
            $table->enum('tax_type', ['percent', 'value'])->after('type');;
        });
        Schema::rename('shipments', 'shop_shipments');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->string('img', 255)->nullable();
            $table->dropColumn('type');
            $table->dropColumn('processing_time');
            $table->dropColumn('tax');
            $table->dropColumn('tax_type');
        });
        Schema::rename('shop_shipments', 'shipments');
    }
}
