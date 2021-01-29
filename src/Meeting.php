<?php

namespace MacsiDigital\Zoom;

use MacsiDigital\Zoom\Support\Model;

/**
 * @property string $schedule_for Email or userId if you want to schedule meeting for another user
 * @property string $topic Meeting topic
 * @property int $type Meeting types: 1 - Instant; 2 - Scheduled; 3 - Recurring with no fixed time; 4 - Recurring with fixed time
 * @property string $start_time Meeting start time
 * @property int $duration Meeting duration in minutes.
 * @property string $timezone Time zone to format start_time. For example, “America/Los_Angeles”.
 * @property string $password. Meeting passcode.
 */
class Meeting extends Model
{
    protected $insertResource = 'MacsiDigital\Zoom\Requests\StoreMeeting';
    protected $updateResource = 'MacsiDigital\Zoom\Requests\UpdateMeeting';

    protected $endPoint = 'meetings';

    protected $customEndPoints = [
        'get' => 'users/{user:id}/meetings',
        'post' => 'users/{user:id}/meetings',
    ];

    protected $allowedMethods = ['find', 'get', 'post', 'patch', 'delete'];

    protected $apiDataField = '';

    protected $apiMultipleDataField = 'meetings';

    protected $dates = [
        'start_time',
        'created_at',
    ];

    public function settings()
    {
        return $this->hasOne(MeetingSetting::class);
    }

    public function recurrence()
    {
        return $this->hasOne(Recurrence::class);
    }

    public function occurrences()
    {
        return $this->hasMany(MeetingOccurrence::class);
    }
    public function participants()
    {
        return $this->hasMany(MeetingParticipant::class);
    }
    public function registrants()
    {
        return $this->hasMany(MeetingRegistrant::class);
    }

    public function polls()
    {
        return $this->hasMany(Poll::class);
    }

    public function registrationQuestions()
    {
        return $this->hasMany(RegistrationQuestion::class);
    }

    public function invitation()
    {
        return $this->hasOne(Invitation::class);
    }

    public function liveStream()
    {
        return $this->hasOne(LiveStream::class);
    }

    public function trackingFields()
    {
        return $this->hasMany(TrackingField::class);
    }

    public function recording()
    {
        return $this->hasOne(MeetingRecording::class);
    }

    public function delete($scheduleForReminder = true)
    {
        return $this->newQuery()->addQuery('schedule_for_reminder', $scheduleForReminder)->delete();
    }

    /**
     * @return bool
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function endMeeting()
    {
        return $this->newQuery()->sendRequest('put', ['meetings/'.$this->id.'/status', ['action' => 'end']])->throw()->successful();
    }
}
