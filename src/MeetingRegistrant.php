<?php

namespace MacsiDigital\Zoom;

use MacsiDigital\Zoom\Support\Model;

/**
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $address
 * @property string $city
 * @property string $country
 * @property string zip
 * @property string $state
 * @property string $phone
 */
class MeetingRegistrant extends Model
{
    protected $insertResource = 'MacsiDigital\Zoom\Requests\StoreRegistrant';

    protected $endPoint = 'meetings/{meeting:id}/registrants';

    protected $allowedMethods = ['get', 'post', 'put'];

    protected $apiMultipleDataField = 'registrants';

    public function getApiMultipleDataField()
    {
        return $this->apiMultipleDataField;
    }

    public function customQuestions()
    {
        return $this->hasMany(CustomQuestion::class);
    }

    public function beforeQuery($query)
    {
        if (isset($this->occurrence_id)) {
            $query->addQuery('occurrence_id', $this->occurrence_id);
        }
    }

    public function beforeInsert($query)
    {
        if (isset($this->occurrence_id)) {
            $query->addQuery('occurrence_id', $this->occurrence_id);
        }
    }

    /**
     * @param string $action "approve", "cancel", "deny"
     * @return bool
     * @throws \Illuminate\Http\Client\RequestException
     */
    protected function updateAction($action)
    {
        if ($this->exists()) {
            if (isset($this->occurrence_id)) {
                return $this->newQuery()->sendRequest('put', ['meetings/'.$this->meeting_id.'/registrants/status', ['action' => $action, 'registrants' => [['id' => $this->id, 'email' => $this->email]]], ['occurrence_id' => $this->occurrence_id]])->throw()->successful();
            } else {
                return $this->newQuery()->sendRequest('put', ['meetings/'.$this->meeting_id.'/registrants/status', ['action' => $action, 'registrants' => [['id' => $this->id, 'email' => $this->email]]]])->throw()->successful();
            }
        }
    }

    /**
     * @return bool
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function approve()
    {
        return $this->updateAction('approve');
    }

    /**
     * @return bool
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function deny()
    {
        return $this->updateAction('deny');
    }

    /**
     * @return bool
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function cancel()
    {
        return $this->updateAction('cancel');
    }
}
