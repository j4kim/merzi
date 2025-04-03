<?php

namespace J4kim\Merzi;

use DateTimeImmutable;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Utils;
use Sabre\VObject\Reader;
use stdClass;

class Calendar
{
    public string $id;
    private string $icsData;
    public array $events = [];

    public function __construct(stdClass $calConfig)
    {
        $this->id = $calConfig->name;
        $this->icsData = $calConfig->icsData;
        $this->parseEvents();
    }

    public function parseEvents()
    {
        $vcalendar = Reader::read($this->icsData);
        $now = new DateTimeImmutable();
        $regex = Config::regex();
        foreach ($vcalendar->VEVENT as $vevent) {
            $start = $vevent->DTSTART->getDateTime();
            $end = $vevent->DTEND->getDateTime();
            $title = (string) $vevent->SUMMARY;
            if ($end < $now) continue;
            if (!preg_match($regex, $title)) continue;
            $title = str_replace("Absence", $this->id, $title);
            $this->events[] = [
                'title' => $title,
                'start' => $start->format('Y-m-d H:i:s'),
                'end' => $end->format('Y-m-d H:i:s'),
                'allDay' => !$vevent->DTSTART->hasTime(),
            ];
        }
    }

    public static function fetchIcs(array $calConfigs)
    {
        $client = new Client();
        $promises = [];
        foreach ($calConfigs as $cal) {
            $promises[$cal->name] = $client->getAsync($cal->url);
        }
        $responses = Utils::unwrap($promises);
        foreach ($calConfigs as $cal) {
            $cal->icsData = (string) $responses[$cal->name]->getBody();
        }
    }

    /**
     * @return array of Calendar objects
     */
    public static function getCalendars(): array
    {
        $calConfigs = array_filter(Config::calendars(), fn($c) => $c->enabled);
        self::fetchIcs($calConfigs);
        foreach ($calConfigs as $calConfig) {
            $calendars[] = new Calendar($calConfig);
        }
        return $calendars;
    }
}
