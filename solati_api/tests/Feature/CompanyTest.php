<?php

namespace Tests\Feature;

use App\Models\Companies;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CompanyTest extends TestCase
{

    /**
     * [Description for authenticate]
     *
     * @return [type]
     *
     *
     * @author     Andres Cantillo Nava
     */
    protected function authenticate()
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

        User::where('nick','testlogin')->delete();

        Log::info(1, [$response->getContent()]);

        $bodyContent = json_decode($response->getContent());

        return $bodyContent->data->access_token;
    }


    /**
     * [Description for test_create_product]
     *
     * @return [type]
     *
     *
     * @author     Andres Cantillo Nava
     */
    public function testCreateCompany()
    {
        $token = $this->authenticate();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->postJson('api/companies',[
            'nit' => '12345654555',
            'name' => 'TEST SOLATI',
            'address' => 'TEST ADDRESS',
            'phone' => '3137399845'
        ]);

        //Write the response in laravel.log
        Log::info(1, [$response->getContent()]);

        Company::where('nit','12345654555')->delete();

        $response->assertStatus(200);
    }

    /**
     * [Description for test_create_product]
     *
     * @return [type]
     *
     *
     * @author     Andres Cantillo Nava
     */
    public function testGetAllCompanies()
    {
        $token = $this->authenticate();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->getJson('api/companies');

        //Write the response in laravel.log
        Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }

}
