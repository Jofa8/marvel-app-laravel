<?php

namespace App\Http\Controllers;

use App\Models\MarvelCharacter;
use Illuminate\Http\Request;

class MarvelCharacterController extends Controller
{
    var $url = 'https://gateway.marvel.com:443/v1/public/';

    public function index($limit = 10) {
        $url = $this->url . 'characters?limit='.$limit.'&';
        $result = json_decode($this->makeRequest($url));
    
        if (isset($result->data) && isset($result->data->results)) {
            $total = $result->data->total;
            $characters = $result->data->results;
    
            if (MarvelCharacter::count() == 0) {
                foreach ($characters as $character) {
                    MarvelCharacter::create([
                        'name' => $character->name,
                        'description' => $character->description,
                        'image' => $character->thumbnail->path . '.' . $character->thumbnail->extension,
                    ]);
                }
            }
        } else {
            $characters = MarvelCharacter::take($limit)->get();
            $total = MarvelCharacter::count();
        }
    
        return view('index', [
            'characters' => $characters,
            'limit' => $limit,
            'total' => $total,
        ]);
    }

    public function generateURL($url) {
        $public_key = '45e7ecc41d75e8d619a12533788c5363';
        $private_key = '615478be5e73e932a8dbcbd35e87e2a6e6d4745e';

        $ts= time();
        $hash = md5($ts.$private_key.$public_key);

        return $url . 'apikey='. $public_key. '&ts='.$ts.'&hash='.$hash;
    }

    public function makeRequest($url) {
        $curl = curl_init();

        $data_url = $this->generateURL($url);

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $data_url
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}
