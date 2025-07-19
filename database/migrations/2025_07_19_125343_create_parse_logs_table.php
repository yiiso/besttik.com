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
        Schema::create('parse_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->comment('用户ID，未登录为null');
            $table->string('ip_address', 45)->comment('IP地址');
            $table->string('video_url', 1000)->comment('解析的视频URL');
            $table->string('platform', 50)->nullable()->comment('视频平台');
            $table->boolean('is_success')->default(false)->comment('是否解析成功');
            $table->text('error_message')->nullable()->comment('错误信息');
            $table->json('parse_result')->nullable()->comment('解析结果数据');
            $table->string('user_agent', 500)->nullable()->comment('用户代理');
            $table->date('parse_date')->comment('解析日期');
            $table->timestamps();
            
            // 索引
            $table->index(['user_id', 'parse_date']);
            $table->index(['ip_address', 'parse_date']);
            $table->index(['is_success', 'parse_date']);
            
            // 外键约束
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parse_logs');
    }
};
