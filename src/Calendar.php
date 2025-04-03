<?php

namespace J4kim\Merzi;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\Utils;

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
            $cal->ics = (string) $responses[$cal->name]->getBody();
        }
        return $calendars;
    }
}
