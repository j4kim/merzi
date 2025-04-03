<?php

namespace J4kim\Merzi;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\Utils;
use Sabre\VObject\Reader;

class Calendar
{
    public static function getEventSources()
    {
        $calendars = Config::calendars();
        $client = new Client();
        $promises = [];
        foreach ($calendars as $cal) {
            $promises[$cal->name] = $client->getAsync($cal->url);
        }
        $responses = Utils::unwrap($promises);
        foreach ($calendars as $cal) {
            $icsData = (string) $responses[$cal->name]->getBody();
            $vcalendar = Reader::read($icsData);
            $cal->events = [];
            foreach ($vcalendar->VEVENT as $vevent) {
                $cal->events[] = [
                    'summary' => (string) $vevent->SUMMARY,
                    'start' => $vevent->DTSTART->getDateTime()->format('Y-m-d H:i:s'),
                    'end' => $vevent->DTEND->getDateTime()->format('Y-m-d H:i:s'),
                ];
            }
        }
        return $calendars;
    }
}
