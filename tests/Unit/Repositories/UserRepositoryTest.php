<?php

namespace Tests\Unit\Repositories;

use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    /**
     * @test
     */
    public function it_is_an_instance_of_base_repository()
    {
        $userRepository = new UserRepository();

        $this->assertInstanceOf(BaseRepository::class, $userRepository);
    }

    /**
     * @test
     */
    public function the_model_property_is_an_eloquent_model_and_app_user_instance()
    {
        $userRepository = new UserRepository();

        $this->assertInstanceOf(Model::class, $userRepository->getModel());
        $this->assertInstanceOf(User::class, $userRepository->getModel());
    }

    /**
     * @test
     */
    public function it_can_create_a_user()
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

        $userRepository = new UserRepository();

        $this->assertInstanceOf(User::class, $userRepository->store($data));
    }

    /**
     * @test
     */
    public function it_can_return_a_collection_of_all_users()
    {
        $users = User::factory(10)->create();
        $userRepository = new UserRepository();

        $this->assertInstanceOf(Collection::class, $userRepository->all());
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_record_does_not_exist()
    {
        $this->expectException(ModelNotFoundException::class);

        $userRepository = new UserRepository();
        $userRepository->find(0);
    }

    /**
     * @test
     */
    public function it_returns_a_model_instance_if_record_exists()
    {
        $user = User::factory(1)->create()->first();

        $userRepository = new UserRepository();
        $model = $userRepository->find($user->getKey());

        $this->assertInstanceOf(Model::class, $model);
        $this->assertInstanceOf(User::class, $model);
    }

    /**
     * @test
     */
    public function it_can_update_an_existing_user()
    {
        $user = User::factory(1)->create()->first();

        $updateData = [
            "id" => $user->getKey(),
            "name" => "my new name"
        ];

        $userRepository = new UserRepository();
        $updated = $userRepository->update($updateData);

        $this->assertTrue($updated);
    }

    /**
     * @test
     */
    public function it_responds_with_false_when_trying_to_update_a_user_that_does_not_exist()
    {
        $updateData = [
            "id" => 0,
            "name" => "my new name"
        ];

        $userRepository = new UserRepository();
        $updated = $userRepository->update($updateData);

        $this->assertFalse($updated);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_when_trying_to_delete_a_user_that_does_not_exist()
    {
        $this->expectException(ModelNotFoundException::class);

        $userRepository = new UserRepository();
        $deleted = $userRepository->destroy(new User());
    }

    /**
     * @test
     */
    public function it_can_delete_an_existing_user()
    {
        $user = User::factory(1)->create()->first();

        $userRepository = new UserRepository();
        $deleted = $userRepository->destroy($user);

        $this->assertTrue((bool) $deleted);
    }
}
