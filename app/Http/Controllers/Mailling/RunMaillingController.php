<?php

namespace App\Http\Controllers\Mailling;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Site\Mailling;
use App\Events\MaillingForRegister;

class RunMaillingController extends Controller
{

    protected $mailling;

    public function __construct(Mailling $mailling)
    {
        $this->mailling = $mailling;
    }

    public function runAll()
    {
        $maillings = $this->mailling->getActiveMaillings();

        $this->run($maillings);

    }

    public function runOne($id)
    {
        $mailling = $this->mailling->getActiveMaillingById($id);

        $this->run($mailling);

    }

    protected function run($maillings)
    {
        $timestampNow = round((time())/60)*60;

        foreach ($maillings as $mailling) {

            $timestampEvent = round( $mailling->timestamp/60)*60;

            if ($timestampNow === $timestampEvent) {
                event(new MaillingForRegister($mailling));
            }
        }
    }
}
