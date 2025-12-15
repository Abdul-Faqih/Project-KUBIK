<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            
            $table->enum('role', ['Student', 'Lecturer', 'Staff'])->nullable()->after('password');

            $table->string('nim')->nullable()->after('role');
            $table->string('nip')->nullable()->after('nim');

            $table->string('enrollment')->nullable()->after('nip');

            $table->string('faculty')->nullable()->after('enrollment');
            $table->string('program')->nullable()->after('faculty');

            $table->string('unit')->nullable()->after('program');
            $table->string('department')->nullable()->after('unit');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'nim',
                'nip',
                'enrollment',
                'faculty',
                'program',
                'unit',
                'department'
            ]);
        });
    }
};
