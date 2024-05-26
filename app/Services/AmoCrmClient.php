<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;

class AmoCrmClient
{
    private $client;
    private $accessToken;

    public function __construct() {
        $this->client = new Client(['base_uri' => env('AMOCRM_DOMAIN')]);
        $this->accessToken =  env('AMOCRM_ACCESS_TOKEN');
    }

    public function addNoteToContactCard($cardId, $noteText) {

        return $this->addNoteToCard($cardId, $noteText, 'contacts');
    }

    public function addNoteToLeadCard($cardId, $noteText) {
        return $this->addNoteToCard($cardId, $noteText, 'leads');
    }


    public function addNoteToCard($cardId, $noteText, $entityType) {
        try{
            $endpoint = "/api/v4/{$entityType}/notes";
            $noteData = [
                'entity_id' => (int) $cardId,
                'note_type' => 'common',
                'params' => [
                    'text' => $noteText,
                ],
            ];
    
            $response = $this->client->post($endpoint, [
                'headers' => [
                    'Authorization' => "Bearer {$this->accessToken}",
                    'Content-Type' => 'application/json',
                ],
                'json' => [$noteData],
            ]);
        }catch(Exception $e){
            return false;
        }


        return json_decode($response->getBody(), true);
    }

}
