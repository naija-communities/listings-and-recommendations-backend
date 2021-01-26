<?php

namespace Tests\Feature\Controllers;

use App\Http\Controllers\AuthController;
use App\Http\Requests\User\StoreRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function it_can_register_a_new_user()
    {
        $data = [
            'name' => 'test user',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
            'password' => 'testpassword',
            'remember_token' => Str::random(10),
            'pronouns' => 'she/her',
            'relationship_status' => 'single',
            'profession' => 'software engineer (web)',
            'province' => 'ontario on',
            'city' => 'toronto',
            'postal_code' => 'M5V0H9',
            'year_of_entry' => '2005-01-01',
            'nigerian_identity' => 'igbo',
            'gender' => 'man',
            'is_admin' => null,
            'topics' => json_encode(["music", "sports", "technology", "poetry"])
        ];

        $controller = new AuthController(new UserRepository());
        $response = $controller->register(new StoreRequest($data));

        $this->assertSame(Response::HTTP_CREATED, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function it_can_successfully_login_an_existing_user()
    {
        $user = User::factory()->create();

        $controller = new AuthController(new UserRepository());
        $response = $controller->login(new Request([
            'email' => $user->email,
            'password' => 'testpassword'
        ]));

        $this->assertSame(200, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function it_responds_with_a_401_when_trying_to_login_a_user_that_does_not_exist()
    {
        $controller = new AuthController(new UserRepository());

        $response = $controller->login(new Request([
            'email' => 'fake@example.com',
            'password' => 'fakepassword'
        ]));

        $this->assertSame(401, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function it_can_logout_an_existing_user()
    {
        $user = User::factory()->create();

        $controller = new AuthController(new UserRepository());
        $login = $controller->login(new Request([
            'email' => $user->email,
            'password' => 'testpassword'
        ]));

        $logout = $controller->logout();
        $this->assertSame(200, $logout->getStatusCode());
    }

    /**
     * @test
     */
    public function it_throws_an_exception_when_trying_to_logout_a_user_that_has_not_been_logged_in()
    {
        $this->expectException(JWTException::class);

        $controller = new AuthController(new UserRepository());

        $response = $controller->logout();
    }
}
