<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * @test
     */
    public function it_is_an_eloquent_model_instance()
    {
        $user = new User();

        $this->assertInstanceOf(Model::class, $user);
    }
}
