<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScanLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scan_logs', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->integer('scanned_id')->nullable(); // ผู้ที่ถูกสแกน
            $table->string('scanner_id')->nullable(); // ผู้ที่สแกน
            $table->string('device_scan')->nullable(); // อุปกรณ์ที่สแกน
            $table->string('ip_scan')->nullable(); // IP ที่สแกน
            $table->string('scan_location')->nullable(); // สถานที่ที่สแกน
            $table->timestamp('scanned_at')->nullable(); // วันที่และเวลาที่สแกน
            $table->json('additional_info')->nullable(); // ข้อมูลเพิ่มเติม
            $table->timestamps(); // created_at, updated_at
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scan_logs');
    }
}
