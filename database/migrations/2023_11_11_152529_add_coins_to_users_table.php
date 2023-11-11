<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // coins カラムを追加する。デフォルト値は0とする。
            $table->integer('coins')->default(0);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // ロールバックの際には coins カラムを削除する。
            $table->dropColumn('coins');
        });
    }
};
