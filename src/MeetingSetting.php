<?php

namespace MacsiDigital\Zoom;

use MacsiDigital\Zoom\Support\Model;

/**
 * @property bool $allow_multiple_devices
 * @property string $alternative_hosts  Alternative host's emails or IDs: multiple values separated by a comma
 * @property int $approval_type
 * @property array $approved_or_denied_countries_or_regions
 * @property string $audio
 * @property string $auto_recording
 * @property bool $host_video Start video when the host joins the meeting.
 * @property bool $participant_video Start video when the participants joins the meeting.
 *
 */
class MeetingSetting extends Model
{
    public function globalDialInNumbers()
    {
        return $this->hasMany(GlobalDialInNumber::class);
    }

    public function globalDialInCountries()
    {
        return $this->hasMany(GlobalDialInCountry::class);
    }
}
