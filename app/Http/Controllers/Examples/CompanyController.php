<?php

namespace App\Http\Controllers\Examples;

use Faker\Generator as Faker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Faker $faker)
    {
        $array = [];

        for ($i = 1; $i < 6; $i++) { 
            $array[] = [
                'id'      => $i,
                'name'    => $faker->company,
                'phase'   => $faker->catchPhrase,
                'email'   => $faker->companyEmail,
                'website' => $faker->domainName,
                'owner'   => $faker->name,
                'company_address' => [
                    'id'         => $i,
                    'country'    => $faker->country,
                    'state'      => $faker->state,
                    'city'       => $faker->city,
                    'street'     => $faker->streetName,
                    'postcode'   => $faker->postcode,
                    'company_id' => $i,
                    'created_at' => $faker->iso8601,
                    'updated_at' => $faker->iso8601
                ],
                'phone'   => $faker->e164PhoneNumber,
                'created_at' => $faker->iso8601,
                'updated_at' => $faker->iso8601
            ];
        }

        return $array;
    }
}
