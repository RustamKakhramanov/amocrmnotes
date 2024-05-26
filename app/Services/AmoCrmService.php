<?php

namespace App\Services;

use App\DTOs\CardDataDTO;
use App\Enums\AmoCrmOperationTypes;

class AmoCrmService
{
    protected AmoCrmCardWorker $cardWorker;

    public function __construct()
    {
        $this->cardWorker = new AmoCrmCardWorker();
    }


    public function handle($data)
    {
        $dataForNotes = [];

        if (isset($data['leads']['add'])) {
            foreach ($data['leads']['add'] as $lead) {
                $dataForNotes[]  = $this->cardWorker->makeForCreateLead($lead);
            }
        }

        if (isset($data['leads']['update'])) {
            foreach ($data['leads']['update'] as $lead) {
                $dataForNotes[]  = $this->cardWorker->makeForUpdateLead($lead);
            }
        }

        if (isset($data['contacts']['add'])) {
            foreach ($data['contacts']['add'] as $contact) {
                $dataForNotes[]  = $this->cardWorker->makeForCreateContact($contact);
            }
        }

        if (isset($data['contacts']['update'])) {
            foreach ($data['contacts']['update'] as $contact) {
              $dataForNotes[]  = $this->cardWorker->makeForUpdateLead($contact);
            }
        }

        $this->addNotesToCards($dataForNotes);
    }

    public function  addNotesToCards(array $data)
    {
        $client = new AmoCrmClient();

        foreach ($data as $dto) {
            if($dto->type == AmoCrmOperationTypes::CreateCard || AmoCrmOperationTypes::UpdateCard){
                $client->addNoteToLeadCard($dto->id, $dto->message);
            }else {
                $client->addNoteToContactCard($dto->id, $dto->message);
            }
        }
    }

}
