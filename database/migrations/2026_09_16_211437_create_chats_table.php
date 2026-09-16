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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->references('id')->on('conversations')->after('id');
            $table->enum('type', [
                'text',
                'image',
                'file',
                'voice',
                'video',
            ])->default('text')->after('message');

            $table->foreignId('reply_to_id')
                ->nullable()
                ->constrained('chats')
                ->nullOnDelete();
             $table->boolean('is_edited')->default(false);
             $table->timestamp('edited_at')->nullable();
            $table->timestamp('deleted_for_everyone_at')->nullable();
            $table->foreignId('sender_id')->references('id')->on('members'); 
            $table->longText('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
