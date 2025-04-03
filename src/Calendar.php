<?php

namespace J4kim\Merzi;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\Utils;
use Sabre\VObject\Reader;

class Calendar
{
    public array $events;

    public function __construct(
        public string $id,
        private string $icsData,
        public ?string $color = null,
    ) {
        $this->parseEvents();
    }

    public function parseEvents()
    {
        $vcalendar = Reader::read($this->icsData);
        foreach ($vcalendar->VEVENT as $vevent) {
            $this->events[] = [
                'title' => (string) $vevent->SUMMARY,
                'start' => $vevent->DTSTART->getDateTime()->format('Y-m-d H:i:s'),
                'end' => $vevent->DTEND->getDateTime()->format('Y-m-d H:i:s'),
            ];
        }
    }

    /**
     * @return array of Calendar objects
     */
    public static function getCalendars(): array
    {
        $calConfigs = Config::calendars();
        $client = new Client();
        $promises = [];
        foreach ($calConfigs as $cal) {
            $promises[$cal->name] = $client->getAsync($cal->url);
        }
        $responses = Utils::unwrap($promises);
        $calendars = [];
        foreach ($calConfigs as $cal) {
            $icsData = (string) $responses[$cal->name]->getBody();
            $calendars[] = new Calendar($cal->name, $icsData, $cal->color);
        }
        return $calendars;
    }
}
