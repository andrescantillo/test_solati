<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AuthTest extends TestCase
{

    /**
     * [Description for testLogin]
     *
     * @return [type]
     *
     * Created at: 2/6/2023, 8:12:50 AM (America/Bogota)
     * @author     Andres Cantillo Nava
     */
    public function testLogin()
    {
        // Creating Users
        User::create([
            'name' => 'Test Login',
            'nick' => 'testlogin',
            'email'=> 'test@example.com',
            'password' => $password = bcrypt('123456789')
        ]);

        // Simulated landing
        $response = $this->postJson('api/auth/login',[
            'nick' => 'testlogin',
            'password' => '123456789',
        ]);

        //Write the response in laravel.log
        Log::info(1, [$response->getContent()]);

        // Determine whether the login is successful and receive token
        $response->assertStatus(200);

        // Delete users
        User::where('nick','testlogin')->delete();
    }
}
