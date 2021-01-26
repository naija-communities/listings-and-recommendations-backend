<?php

namespace Tests\Integration\Requests\User;

use App\Http\Requests\User\StoreRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class StoreRequestTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    /**
     * @test
     */
    public function it_is_an_instance_of_form_request()
    {
        $storeRequest = new StoreRequest();

        $this->assertInstanceOf(FormRequest::class, $storeRequest);
    }

    /**
     * @test
     */
    public function it_responds_with_a_422_if_the_request_is_empty()
    {
        $response = $this->json("POST", "api/auth/register", []);

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function it_responds_with_a_422_if_the_name_field_is_null()
    {
        $response = $this->json("POST", "api/auth/register", [
            'email' => 'test@example.com',
            'password' => 'testpassword',
            'pronouns' => 'she/her',
            'relationship_status' => 'taken',
            'profession' => 'software engineer (mobile)',
            'province' => 'Ontario ON',
            'city' => 'toronto',
            'postal_code' => 'M5V0H7',
            'year_of_entry' => '2011-10-01'
        ]);

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey("name", $content["errors"]);
        $this->assertSame("The name field is required.", $content["errors"]["name"][0]);
    }

    /**
     * @test
     */
    public function it_responds_with_a_422_if_the_email_field_is_null()
    {
        $response = $this->json("POST", "api/auth/register", [
            'name' => 'test user',
            'password' => 'testpassword',
            'pronouns' => 'she/her',
            'relationship_status' => 'taken',
            'profession' => 'software engineer (mobile)',
            'province' => 'Ontario ON',
            'city' => 'toronto',
            'postal_code' => 'M5V0H7',
            'year_of_entry' => '2011-10-01'
        ]);

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey("email", $content["errors"]);
        $this->assertSame("The email field is required.", $content["errors"]["email"][0]);
    }

    /**
     * @test
     */
    public function it_responds_with_a_422_if_the_email_field_is_not_a_valid_email()
    {
        $response = $this->json("POST", "api/auth/register", [
            'name' => 'test user',
            'email' => 'invalid',
            'password' => 'testpassword',
            'pronouns' => 'she/her',
            'relationship_status' => 'taken',
            'profession' => 'software engineer (mobile)',
            'province' => 'Ontario ON',
            'city' => 'toronto',
            'postal_code' => 'M5V0H7',
            'year_of_entry' => '2011-10-01'
        ]);

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey("email", $content["errors"]);
        $this->assertSame("The email must be a valid email address.", $content["errors"]["email"][0]);
    }

    /**
     * @test
     */
    public function it_responds_with_a_422_if_the_password_field_is_null()
    {
        $response = $this->json("POST", "api/auth/register", [
            'name' => 'test user',
            'email' => 'test@example.com',
            'pronouns' => 'she/her',
            'relationship_status' => 'taken',
            'profession' => 'software engineer (mobile)',
            'province' => 'Ontario ON',
            'city' => 'toronto',
            'postal_code' => 'M5V0H7',
            'year_of_entry' => '2011-10-01'
        ]);

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey("password", $content["errors"]);
        $this->assertSame("The password field is required.", $content["errors"]["password"][0]);
    }

    /**
     * @test
     */
    public function it_responds_with_a_422_if_the_password_field_is_less_than_eight_characters()
    {
        $response = $this->json("POST", "api/auth/register", [
            'name' => 'test user',
            'email' => 'test@example.com',
            'password' => 'less',
            'pronouns' => 'she/her',
            'relationship_status' => 'taken',
            'profession' => 'software engineer (mobile)',
            'province' => 'Ontario ON',
            'city' => 'toronto',
            'postal_code' => 'M5V0H7',
            'year_of_entry' => '2011-10-01'
        ]);

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey("password", $content["errors"]);
        $this->assertSame("The password must be at least 8 characters.", $content["errors"]["password"][0]);
    }

    /**
     * @test
     */
    public function it_responds_with_a_422_if_the_pronouns_field_is_null()
    {
        $response = $this->json("POST", "api/auth/register", [
            'name' => 'test user',
            'email' => 'test@example.com',
            'password' => 'testpassword',
            'relationship_status' => 'taken',
            'profession' => 'software engineer (mobile)',
            'province' => 'Ontario ON',
            'city' => 'toronto',
            'postal_code' => 'M5V0H7',
            'year_of_entry' => '2011-10-01'
        ]);

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey("pronouns", $content["errors"]);
        $this->assertSame("The pronouns field is required.", $content["errors"]["pronouns"][0]);
    }

    /**
     * @test
     */
    public function it_responds_with_a_422_if_the_pronouns_field_is_not_in_the_allowed_list()
    {
        $response = $this->json("POST", "api/auth/register", [
            'name' => 'test user',
            'email' => 'test@example.com',
            'password' => 'testpassword',
            'pronouns' => 'not allowed',
            'relationship_status' => 'taken',
            'profession' => 'software engineer (mobile)',
            'province' => 'Ontario ON',
            'city' => 'toronto',
            'postal_code' => 'M5V0H7',
            'year_of_entry' => '2011-10-01'
        ]);

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey("pronouns", $content["errors"]);
        $this->assertSame("The selected pronoun is invalid.", $content["errors"]["pronouns"][0]);
    }

    /**
     * @test
     */
    public function it_responds_with_a_422_if_the_relationship_status_field_is_null()
    {
        $response = $this->json("POST", "api/auth/register", [
            'name' => 'test user',
            'email' => 'test@example.com',
            'password' => 'testpassword',
            'pronouns' => 'she/her',
            'profession' => 'software engineer (mobile)',
            'province' => 'Ontario ON',
            'city' => 'toronto',
            'postal_code' => 'M5V0H7',
            'year_of_entry' => '2011-10-01'
        ]);

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey("relationship_status", $content["errors"]);
        $this->assertSame("The relationship status field is required.", $content["errors"]["relationship_status"][0]);
    }

    /**
     * @test
     */
    public function it_responds_with_a_422_if_the_relationship_status_field_is_not_in_the_allowed_list()
    {
        $response = $this->json("POST", "api/auth/register", [
            'name' => 'test user',
            'email' => 'test@example.com',
            'password' => 'testpassword',
            'pronouns' => 'she/her',
            'relationship_status' => 'not allowed',
            'profession' => 'software engineer (mobile)',
            'province' => 'Ontario ON',
            'city' => 'toronto',
            'postal_code' => 'M5V0H7',
            'year_of_entry' => '2011-10-01'
        ]);

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey("relationship_status", $content["errors"]);
        $this->assertSame("The status is invalid.", $content["errors"]["relationship_status"][0]);
    }

    /**
     * @test
     */
    public function it_responds_with_a_422_if_the_profession_field_is_null()
    {
        $response = $this->json("POST", "api/auth/register", [
            'name' => 'test user',
            'email' => 'test@example.com',
            'password' => 'testpassword',
            'pronouns' => 'she/her',
            'relationship_status' => 'single',
            'province' => 'Ontario ON',
            'city' => 'toronto',
            'postal_code' => 'M5V0H7',
            'year_of_entry' => '2011-10-01'
        ]);

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey("profession", $content["errors"]);
        $this->assertSame("The profession field is required.", $content["errors"]["profession"][0]);
    }

    /**
     * @test
     */
    public function it_responds_with_a_422_if_the_profession_field_is_not_in_the_allowed_list()
    {
        $response = $this->json("POST", "api/auth/register", [
            'name' => 'test user',
            'email' => 'test@example.com',
            'password' => 'testpassword',
            'pronouns' => 'she/her',
            'relationship_status' => 'single',
            'profession' => 'not allowed',
            'province' => 'Ontario ON',
            'city' => 'toronto',
            'postal_code' => 'M5V0H7',
            'year_of_entry' => '2011-10-01'
        ]);

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey("profession", $content["errors"]);
        $this->assertSame("The selected profession is invalid.", $content["errors"]["profession"][0]);
    }

    /**
     * @test
     */
    public function it_responds_with_a_422_if_the_province_field_is_null()
    {
        $response = $this->json("POST", "api/auth/register", [
            'name' => 'test user',
            'email' => 'test@example.com',
            'password' => 'testpassword',
            'pronouns' => 'she/her',
            'relationship_status' => 'single',
            'profession' => 'software engineer (mobile)',
            'city' => 'toronto',
            'postal_code' => 'M5V0H7',
            'year_of_entry' => '2011-10-01'
        ]);

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey("province", $content["errors"]);
        $this->assertSame("The province field is required.", $content["errors"]["province"][0]);
    }

    /**
     * @test
     */
    public function it_responds_with_a_422_if_the_city_field_is_null()
    {
        $response = $this->json("POST", "api/auth/register", [
            'name' => 'test user',
            'email' => 'test@example.com',
            'password' => 'testpassword',
            'pronouns' => 'she/her',
            'relationship_status' => 'single',
            'profession' => 'software engineer (mobile)',
            'province' => 'Ontario ON',
            'postal_code' => 'M5V0H7',
            'year_of_entry' => '2011-10-01',
            'nigerian_identity' => 'yoruba'
        ]);

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey("city", $content["errors"]);
        $this->assertSame("The city field is required.", $content["errors"]["city"][0]);
    }

    /**
     * @test
     */
    public function it_responds_with_a_422_if_the_postal_code_field_is_null()
    {
        $response = $this->json("POST", "api/auth/register", [
            'name' => 'test user',
            'email' => 'test@example.com',
            'password' => 'testpassword',
            'pronouns' => 'she/her',
            'relationship_status' => 'single',
            'profession' => 'software engineer (mobile)',
            'province' => 'Ontario ON',
            'city' => 'toronto',
            'year_of_entry' => '2011-10-01'
        ]);

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey("postal_code", $content["errors"]);
        $this->assertSame("The postal code field is required.", $content["errors"]["postal_code"][0]);
    }

    /**
     * @test
     */
    public function it_responds_with_a_422_if_the_postal_code_field_is_more_than_6_characters_long()
    {
        $response = $this->json("POST", "api/auth/register", [
            'name' => 'test user',
            'email' => 'test@example.com',
            'password' => 'testpassword',
            'pronouns' => 'she/her',
            'relationship_status' => 'single',
            'profession' => 'software engineer (mobile)',
            'province' => 'Ontario ON',
            'city' => 'toronto',
            'postal_code' => 'invalid',
            'year_of_entry' => '2011-10-01'
        ]);

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey("postal_code", $content["errors"]);
        $this->assertSame("The postal_code must be 6 characters long.", $content["errors"]["postal_code"][0]);
    }

    /**
     * @test
     */
    public function it_responds_with_a_422_if_the_postal_code_field_is_less_than_6_characters_long()
    {
        $response = $this->json("POST", "api/auth/register", [
            'name' => 'test user',
            'email' => 'test@example.com',
            'password' => 'testpassword',
            'pronouns' => 'she/her',
            'relationship_status' => 'single',
            'profession' => 'software engineer (mobile)',
            'province' => 'Ontario ON',
            'city' => 'toronto',
            'postal_code' => 'less',
            'year_of_entry' => '2011-10-01'
        ]);

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey("postal_code", $content["errors"]);
        $this->assertSame("The postal_code must be 6 characters long.", $content["errors"]["postal_code"][0]);
    }

    /**
     * @test
     */
    public function it_responds_with_a_422_if_the_postal_code_field_is_invalid_6_characters()
    {
        $response = $this->json("POST", "api/auth/register", [
            'name' => 'test user',
            'email' => 'test@example.com',
            'password' => 'testpassword',
            'pronouns' => 'she/her',
            'relationship_status' => 'single',
            'profession' => 'software engineer (mobile)',
            'province' => 'Ontario ON',
            'city' => 'toronto',
            'postal_code' => 'AAAAAA',
            'year_of_entry' => '2011-10-01'
        ]);

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey("postal_code", $content["errors"]);
        $this->assertSame("The postal_code is invalid.", $content["errors"]["postal_code"][0]);
    }

    /**
     * @test
     */
    public function it_responds_with_a_422_if_the_year_of_entry_is_null()
    {
        $response = $this->json("POST", "api/auth/register", [
            'name' => 'test user',
            'email' => 'test@example.com',
            'password' => 'testpassword',
            'pronouns' => 'she/her',
            'relationship_status' => 'single',
            'profession' => 'software engineer (mobile)',
            'province' => 'Ontario ON',
            'city' => 'toronto',
            'postal_code' => 'M5V0H9'
        ]);

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey("year_of_entry", $content["errors"]);
        $this->assertSame("The year of entry field is required.", $content["errors"]["year_of_entry"][0]);
    }

    /**
     * @test
     */
    public function it_responds_with_a_422_if_the_year_of_entry_is_not_a_valid_date_format()
    {
        $response = $this->json("POST", "api/auth/register", [
            'name' => 'test user',
            'email' => 'test@example.com',
            'password' => 'testpassword',
            'pronouns' => 'she/her',
            'relationship_status' => 'single',
            'profession' => 'software engineer (mobile)',
            'province' => 'Ontario ON',
            'city' => 'toronto',
            'postal_code' => 'M5V0H9',
            'year_of_entry' => 'invalid'
        ]);

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey("year_of_entry", $content["errors"]);
        $this->assertSame("The year of entry does not match the format Y-m-d.", $content["errors"]["year_of_entry"][0]);
    }

    /**
     * @test
     */
    public function it_responds_with_a_OK_status_if_validation_passes()
    {
        $response = $this->json("POST", "api/auth/register", [
            'name' => 'test user',
            'email' => 'test@example.com',
            'password' => 'testpassword',
            'pronouns' => 'she/her',
            'relationship_status' => 'single',
            'profession' => 'software engineer (mobile)',
            'province' => 'Ontario ON',
            'city' => 'toronto',
            'postal_code' => 'M5V0H9',
            'year_of_entry' => '2011-10-01'
        ]);

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
    }
}

