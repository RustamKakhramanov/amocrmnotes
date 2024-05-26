<?php

namespace App\Services;

use App\DTOs\CardDataDTO;
use App\Enums\AmoCrmOperationTypes;

class AmoCrmCardWorker
{
    public function makeForCreateContact($contact){
        $dto = new CardDataDTO();
        $dto->id = $contact['id'];
        $dto->type = AmoCrmOperationTypes::CreateContact;
        $dto->message = "Название контакта: {$contact['name']}\nОтветственный: {$contact['responsible_user_id']}\nВремя добавления: " . date('Y-m-d H:i:s', $contact['created_at']);

        return $dto;
    }
    public function makeForCreateLead($lead){
        $dto = new CardDataDTO();
        $dto->id = $lead['id'];
        $dto->type = AmoCrmOperationTypes::CreateCard;
        $dto->message = "Название сделки: {$lead['name']}\nОтветственный: {$lead['responsible_user_id']}\nВремя добавления: " . date('Y-m-d H:i:s', $lead['created_at']);

        return $dto;
    }

    public function makeForUpdateLead($lead){
        $changedFields = [];
        foreach ($lead['updated_fields'] as $field => $value) {
            $changedFields[] = "{$field}: {$value}";
        }

        $dto = new CardDataDTO();
        $dto->id = $lead['id'];
        $dto->type = AmoCrmOperationTypes::CreateCard;
        $dto->message = "Измененные поля: " . implode(', ', $changedFields) . "\nВремя изменения: " . date('Y-m-d H:i:s', $lead['updated_at']);

        return $dto;

    }

    public function makeForUpdateContact($contact){
        $changedFields = [];
        foreach ($contact['updated_fields'] as $field => $value) {
            $changedFields[] = "{$field}: {$value}";
        }

        $dto = new CardDataDTO();
        $dto->id = $contact['id'];
        $dto->type = AmoCrmOperationTypes::CreateCard;
        $dto->message =  "Измененные поля: " . implode(', ', $changedFields) . "\nВремя изменения: " . date('Y-m-d H:i:s', $contact['updated_at']);

        return $dto;

    }
}
