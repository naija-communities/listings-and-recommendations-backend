<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('pronouns', ['she/her', 'he/him'. 'they/them', 'rather not say']);
            $table->enum('relationship_status', ['single', 'very single', 'taken']);
            $table->enum('profession', [
                'accountant',
                'architect',
                'artist',
                'banker',
                'civil engineer',
                'forex trader',
                'family doctor',
                'farmer',
                'health care professional',
                'medical doctor',
                'music teacher',
                'nurse',
                'social worker',
                'network engineer',
                'software engineer (web)',
                'software engineer (mobile)',
                'ui/ux designer',
                'project management',
                'student',
                'tutor/educator',
                'real estate agent',
                'retail business owner',
                'small business owner',
                'lawyer',
                'immigration lawyer',
                'military',
                'military veteran',
                'religious leader',
                'writer',
                'other',
                'yputuber',
                'rather not say'
            ]);
            $table->enum('province', [
                'Alberta AB',
                'British Columbia BC',
                'Manitoba MAN',
                'Newfoundland and Labrador NFL',
                'Nova Scotia NS',
                'New Brunswick NB',
                'Nunavut NVT',
                'Northwest Territories NWT',
                'Ontario ON',
                'Prince Edward Island PEI',
                'Quebec QUE',
                'Saskatchewan SASK',
                'Yukon YT'
            ]);
            $table->string('city');
            $table->string('postal_code');
            $table->date('year_of_entry');
            $table->enum('nigerian_identity', [
                'igbo',
                'yoruba',
                'hausa',
                'port harcourt',
                'calabar',
                'warri',
                'niger delta',
                'edo',
                'nigerian'
            ])->nullable();
            $table->enum('gender', [
                'man',
                'woman',
                'trans man',
                'trans woman',
                'transgender',
                'rather not say'
            ])->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
