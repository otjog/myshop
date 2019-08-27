<?php

namespace App\Listeners;

use App\Events\MaillingForRegister;
use App\Models\Shop\Offer\Offer;
use App\Models\Shop\Product\Product;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Settings;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForRegister;

class SendMailForRegister
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MaillingForRegister  $event
     * @return void
     */
    public function handle(MaillingForRegister $event)
    {
        $settings = Settings::getInstance();

        $offers = new Offer();

        $data['mailling'] = $event->mailling;

        $data['shop']['offers'] = $offers->getActiveOfferByName('sale', 10);

        $globalData = $settings->pushArrayParameters($data);

        dd($globalData);

        foreach ($globalData['mailling'][0]->mailList as $mailData) {
            Mail::to($mailData['email'], $mailData['name'])
                ->send(new ForRegister(['global_data' => $globalData]));
        }
    }
}
