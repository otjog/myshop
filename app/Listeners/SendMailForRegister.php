<?php

namespace App\Listeners;

use App\Events\MaillingForRegister;
use App\Models\Shop\Offer\Offer;
use App\Models\Shop\CustomerGroup;
use App\Models\Settings;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForRegister;
use Illuminate\Support\Facades\Storage;
use App\Models\Site\Mailling;

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

        $customerGroup = new CustomerGroup();

        $customerGroupForMailling = $customerGroup->getCustomerGroupById($data['mailling']->customer_group_id);

        $settings->getParameters();

        $settings->addParameter('components.shop.customer_group', $customerGroupForMailling);

        $offerName = $event->mailling->options['shop_offer'];

        $data['shop']['offers'] = $offers->getActiveOfferByName($offerName, 10);

        $globalData = $settings->pushArrayParameters($data);

        foreach ($globalData['mailling']['mailList'] as $mailData) {

            $mailData['subject'] = str_ireplace('{{full_name}}', $mailData['full_name'], $event->mailling->options['mail_subject']);
            $globalData['mailling']['current'] = $mailData;

            Mail::to($mailData['email'], $mailData['full_name'])
                ->send(new ForRegister($globalData));
        }
    }
}
