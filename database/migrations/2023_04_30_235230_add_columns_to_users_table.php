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
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name', 'last_name');

            $table->string('first_name')->after('id');
            $table->string('phone')->nullable()->after('password');
            $table->string('photo')->nullable()->after('phone');
            $table->text('notes')->nullable()->after('phone');
            $table->datetime('last_review_dt')->nullable()->after('phone');
            $table->datetime('next_review_dt')->nullable()->after('phone');
            $table->date('start_dt')->nullable()->after('phone');
            $table->foreignId('status_id')->nullable()->after('phone');
            $table->foreignId('job_title_id')->nullable()->after('phone');
            $table->foreignId('satisfaction_level_id')->nullable()->after('job_title_id');
            $table->foreignId('department_id')->nullable()->after('phone');
            $table->foreignId('access_level_id')->default(3)->after('phone');

            $table->foreign('access_level_id')->references('id')->on('access_levels');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('satisfaction_level_id')->references('id')->on('satisfaction_levels');
            $table->foreign('job_title_id')->references('id')->on('job_titles');
            $table->foreign('status_id')->references('id')->on('employee_statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_job_title_id_foreign');
            $table->dropForeign('users_department_id_foreign');
            $table->dropForeign('users_status_id_foreign');
            $table->dropForeign('users_access_level_id_foreign');

            $table->dropColumn('first_name');
            $table->dropColumn('phone');
            $table->dropColumn('access_level_id');
            $table->dropColumn('department_id');
            $table->dropColumn('job_title_id');
            $table->dropColumn('status_id');
            $table->dropColumn('start_dt');
            $table->dropColumn('next_review_dt');
            $table->dropColumn('last_review_dt');
            $table->dropColumn('notes');
            $table->dropColumn('photo');

            $table->renameColumn('last_name', 'name');
        });
    }
};
