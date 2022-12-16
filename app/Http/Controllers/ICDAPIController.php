<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ICDAPIController extends Controller
{

    private $client_id = "5a85f176-1634-4666-be85-501696ba7849_401a9668-8050-42b8-8088-28f9d8e7642b";
    private $client_secret = "NDKz/ywKUxZ3gwH3GZlpgkEvXga1lZR11Tmf360IIXY=";
    private $grant_type = "client_credentials";
    private $scope = "icdapi_access";

    protected $token_url = "https://icdaccessmanagement.who.int/connect/token";
    protected $token = null;

    public function __construct()
    {
        $headers = [
            'headers' => [
                'cache-control' => 'no-cache',
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json'
            ],
        ];
        $body = [
            'form_params' => [
                'client_id'     => $this->client_id,
                'client_secret' => $this->client_secret,
                'grant_type'    => $this->grant_type,
                'scope'         => $this->scope,
            ]
        ];
        $this->client = new Client($headers);
        try {
            $response = $this->client->post($this->token_url, $body);
            $response = json_decode($response->getBody()->getContents());
            $this->token = $response->access_token;
        } catch(\Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }

        // If more back end ICD APIs required, uncomment so headers can be set for subsequent requests.
        //$this->setRequestHeaders();

    }

    private function setRequestHeaders(){
        $headers = [
            'headers' => [
                'cache-control' => 'no-cache',
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
                'Authorization' => "Bearer $this->token"
            ]
        ];
        $this->client = new Client($headers);
    }

    public function getToken(): \Illuminate\Http\JsonResponse
    {
        return response()->json(['token' => $this->token]);
    }

}
