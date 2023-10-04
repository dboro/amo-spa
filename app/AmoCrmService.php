<?php

namespace App;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Collections\LinksCollection;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMApiNoContentException;
use AmoCRM\Filters\EventsFilter;
use AmoCRM\Filters\Interfaces\HasOrderInterface;
use AmoCRM\Filters\LeadsFilter;
use AmoCRM\Helpers\EntityTypesInterface;
use AmoCRM\Models\ContactModel;
use AmoCRM\Models\CustomFieldsValues\MultitextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\TextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\TextCustomFieldValueModel;
use AmoCRM\Models\NoteType\CommonNote;
use AmoCRM\OAuth2\Client\Provider\AmoCRMException;
use App\Dto\AddContactDto;
use App\Events\AddContactEvent;
use League\OAuth2\Client\Token\AccessTokenInterface;

class AmoCrmService
{
    public function __construct(
        protected AmoCRMApiClient $apiClient,
        protected AmoCrmTokenStore $tokenStore
    ){
        $this->connectToApi();
    }

    protected function connectToApi(): void
    {
        if (! $this->tokenStore->isToken()) {
            $accessToken = $this->apiClient->getOAuthClient()->getAccessTokenByCode(config('amo-crm.code'));

            $this->tokenStore->saveToken([
                'accessToken' => $accessToken->getToken(),
                'refreshToken' => $accessToken->getRefreshToken(),
                'expires' => $accessToken->getExpires(),
                'baseDomain' => config('amo-crm.domain')]
            );
        }

        $accessToken = $this->tokenStore->getToken();

        $this->apiClient->setAccessToken($accessToken)
            ->setAccountBaseDomain($accessToken->getValues()['baseDomain'])
            ->onAccessTokenRefresh(
                function (AccessTokenInterface $accessToken, string $baseDomain) {
                    $this->tokenStore->saveToken(
                        [
                            'accessToken' => $accessToken->getToken(),
                            'refreshToken' => $accessToken->getRefreshToken(),
                            'expires' => $accessToken->getExpires(),
                            'baseDomain' => $baseDomain,
                        ]
                    );
                }
            );
    }

    public function getLeads(): array
    {
        $leadsFilter = new LeadsFilter();
        $leadsFilter->setOrder('created_at', HasOrderInterface::SORT_DESC);

        try {
            return $this->apiClient->leads()->get($leadsFilter, ['contacts'])->toArray();
        } catch (AmoCRMApiNoContentException) {
            return [];
        }
    }

    public function addContact(AddContactDto $dto)
    {
        try {
            // добавляем контакт с полем телефон
            $multitextCustomFieldValuesModel = new MultitextCustomFieldValuesModel();
            $multitextCustomFieldValuesModel->setFieldCode('PHONE')
                ->setValues(
                    (new TextCustomFieldValueCollection())->add(
                        (new TextCustomFieldValueModel())->setValue($dto->phone)
                    )
                );
            $contactCustomFieldsValuesCollection =  new CustomFieldsValuesCollection();
            $contactCustomFieldsValuesCollection->add($multitextCustomFieldValuesModel);

            $contact = new ContactModel();
            $contact->setName($dto->name);
            $contact->setCustomFieldsValues($contactCustomFieldsValuesCollection);

            $this->apiClient->contacts()->addOne($contact);

            // привязываем к сделке
            $lead = $this->apiClient->leads()->getOne($dto->leadId);
            $links = new LinksCollection();
            $links->add($lead);

            $this->apiClient->contacts()->link($contact, $links);

            // добавляем примечание
            $note = new CommonNote();
            $note->setEntityId($contact->getId());
            $note->setText($dto->comment);
            $note->setCreatedBy(0);

            $this->apiClient->notes(EntityTypesInterface::CONTACTS)->addOne($note);

            AddContactEvent::dispatch('Добавление контакта', true);
        } catch (AmoCRMApiException $e) {
            AddContactEvent::dispatch('Добавление контакта', false);
        }
    }
}
