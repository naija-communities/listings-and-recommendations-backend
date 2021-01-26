<?php

namespace Tests\Feature\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserControllerTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        JWTAuth::shouldReceive('parseToken->authenticate')->andReturn($this->user);
    }

    /**
     * @test
     */
    public function it_is_indeed_a_controller_instance()
    {
        $this->actingAs($this->user);

        $controller = new UserController(new UserRepository());

        $this->assertInstanceOf(Controller::class, $controller);
    }

    /**
     * @test
     */
    public function it_can_return_a_collection_of_all_users()
    {
        $users = User::factory(10)->create();

        $controller = new UserController(new UserRepository());
        $decoded = json_decode($controller->allUsers()->getContent(), true);

        $this->assertCount(11, $decoded["users"]);
    }

    /**
     * @test
     */
    public function it_can_retrieve_one_user()
    {
        $controller = new UserController(new UserRepository());
        $found = $controller->oneUser($this->user);

        $this->assertSame(200, $found->getStatusCode());
    }

    /**
     * @test
     */
    public function it_responds_with_a_401_if_the_authenticated_user_tries_to_update_another_users_record()
    {
        $bob =  User::factory()->create();
        $data = ["name" => "poop face"];

        $controller = new UserController(new UserRepository());
        $updated = $controller->update($bob, new UpdateRequest($data));

        $this->assertSame(401, $updated->getStatusCode());
    }

    /**
     * @test
     */
    public function it_responds_with_a_200_if_I_successfully_update_my_record()
    {
        $this->actingAs($this->user);

        $data = ["name" => "your new queen"];

        $controller = new UserController(new UserRepository());
        $updated = $controller->update($this->user, new UpdateRequest($data));

        $this->assertSame(200, $updated->getStatusCode());
    }

    /**
     * @test
     */
    public function it_responds_with_a_401_if_the_authenticated_user_tries_to_delete_another_users_record()
    {
        $bob =  User::factory()->create();

        $controller = new UserController(new UserRepository());
        $updated = $controller->destroy($bob);

        $this->assertSame(401, $updated->getStatusCode());
    }

    /**
     * @test
     */
    public function it_responds_with_a_204_if_I_successfully_update_my_record()
    {
        $this->actingAs($this->user);

        $controller = new UserController(new UserRepository());
        $updated = $controller->destroy($this->user);

        $this->assertSame(204, $updated->getStatusCode());
    }
}
