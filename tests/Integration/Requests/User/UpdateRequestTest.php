<?php

namespace Tests\Integration\Requests\User;

use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UpdateRequestTest extends TestCase
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
    public function it_is_an_instance_of_form_request()
    {
        $storeRequest = new UpdateRequest();

        $this->assertInstanceOf(FormRequest::class, $storeRequest);
    }

    /**
     * @test
     */
    public function it_responds_with_422_if_any_of_the_update_data_fails_validation()
    {
        $this->password();
        $this->pronouns();
        $this->status();
        $this->profession();
        $this->province();
        $this->postalCode();
        $this->year();
        $this->topics();
    }

    private function password()
    {
        $this->actingAs($this->user);

        $response = $this->json("PUT", "api/users/" . $this->user->getkey(), [
            'password' => 'less',
        ]);

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    private function pronouns()
    {
        $this->actingAs($this->user);

        $response = $this->json("PUT", "api/users/" . $this->user->getkey(), [
            'pronouns' => 'invalid',
        ]);

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    private function status()
    {
        $this->actingAs($this->user);

        $response = $this->json("PUT", "api/users/" . $this->user->getkey(), [
            'relationship_status' => 'invalid',
        ]);

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    private function profession()
    {
        $this->actingAs($this->user);

        $response = $this->json("PUT", "api/users/" . $this->user->getkey(), [
            'profession' => 'invalid',
        ]);

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    private function province()
    {
        $this->actingAs($this->user);

        $response = $this->json("PUT", "api/users/" . $this->user->getkey(), [
            'province' => 'invalid',
        ]);

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    private function postalCode()
    {
        $this->actingAs($this->user);

        $response = $this->json("PUT", "api/users/" . $this->user->getkey(), [
            'postal_code' => 'AAAAAA',
        ]);

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    private function year()
    {
        $this->actingAs($this->user);

        $response = $this->json("PUT", "api/users/" . $this->user->getkey(), [
            'year_of_entry' => '2020',
        ]);

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    private function topics()
    {
        $this->actingAs($this->user);

        $response = $this->json("PUT", "api/users/" . $this->user->getkey(), [
            'topics' => ["not json"],
        ]);

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }
}
