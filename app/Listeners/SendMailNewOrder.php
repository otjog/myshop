<?php

namespace App\Listeners;

use App\Events\NewOrder;
use App\Mail\OrderShipped;
use App\Facades\GlobalData;
use App\Models\Shop\Order\Order;
use App\Models\Shop\Product\Product;
use Illuminate\Support\Facades\Mail;

class SendMailNewOrder{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(){

    }

    /**
     * Handle the event.
     *
     * @param  NewOrder  $event
     * @return void
     */
    public function handle(NewOrder $event)
    {
        $orders = new Order();

        $products = new Product();

        $data['order'] = $orders->getOrderById($products, $event->orderId);

        $globalData = GlobalData::pushArrayParameters($data);

        $sending = Mail::to(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        /*Если заказ оформлен по телефону и адрес почты указан `номертелефона@nomail.ru` письмо не отправляем по этому адресу*/
        if (!stripos($data['order']->customer->email, '@nomail.')) {
            $sending->cc($data['order']->customer->email, $data['order']->customer->full_name);
        }
        if(env('SECOND_MAIL_FROM_ADDRESS') !== null || env('SECOND_MAIL_FROM_ADDRESS') !== '' ) {
            $sending->bcc(env('SECOND_MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        }
        $sending->send(new OrderShipped(['global_data' => $globalData]));


    }
}
