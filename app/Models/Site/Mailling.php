<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Mailling extends Model
{
    public function getActiveMaillings()
    {
        $maillings = self::where('active', 1)
            ->select('alias', 'name', 'file_src', 'time', 'customer_group_id')
            ->get();

        $maillings = $this->addNormalizeTime($maillings);

        return $maillings;
    }

    public function getActiveMaillingById($id)
    {
        $mailling = self::where('active', 1)
            ->where('id', $id)
            ->select('alias', 'name', 'file_src', 'time', 'customer_group_id')
            ->get();

        $mailling = $this->addNormalizeTime($mailling);

        $maillings = $this->addMailList($mailling);

        return $maillings;
    }

    protected function addNormalizeTime ($events)
    {
        $datetime = [
            'year'  => date('Y'),
            'month' => date('m'),
            'day'   => date('d'),
            'hour'  => date('H'),
            'min'   => date('i'),
        ];

        foreach ($events as $event) {
            list($min, $hour, $day, $month) = explode(' ', $event->time);

            if($min !== '*')
                $datetime['min'] = $min;
            if($hour !== '*')
                $datetime['hour'] = $hour;
            if($day !== '*')
                $datetime['day'] = $day;
            if($month !== '*')
                $datetime['month'] = $month;

            $event->datetime = $datetime['year'] . '-' . $datetime['month'] . '-' . $datetime['day'] . ' ' . $datetime['hour'] . ':' . $datetime['min'] . ':00';

            $event->timestamp = strtotime($event->datetime);

        }

        return $events;
    }

    protected function addMailList($maillings)
    {
        foreach ($maillings as $mailling) {
            if ($mailling->file_src !== null) {
                $mailling->mailList = $this->getMailListFromFile($mailling->file_src);
            }
        }
        return $maillings;
    }

    protected function getMailListFromFile($filepath)
    {
        $data = [];

        if (is_file($filepath)) {
            $strings = file($filepath);

            foreach ($strings as $string) {
                $string = str_ireplace(["\t", "\n", "\r", "\0", "\x0B"],' ', $string);
                $delimeterPosition = stripos($string, ' ');

                $data[] = [
                    'email' => substr($string, 0, $delimeterPosition),
                    'name' => trim(substr($string, $delimeterPosition))
                ];

            }
        }

        return $data;
    }

}
