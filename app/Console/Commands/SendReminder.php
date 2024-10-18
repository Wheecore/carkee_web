<?php

namespace App\Console\Commands;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends out reminders';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $now = Carbon::now();
        $date = Carbon::parse($now)->toDateString();
        $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $now);
        $orders = Order::whereDate('created_at', '<=', $date)->get();
        foreach ($orders as $order) {
            $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $order->created_at);
            $diff_in_hours = $to->diffInHours($from);
            $end = Carbon::parse($order->created_at);
            $length = $end->diffInDays($now);
            //        dd($diff_in_hours);// Output: 6
            if ($diff_in_hours < 2) {
                // Generate Notification
                \App\Models\Notification::create([
                    'user_id' => $order->user_id,
                    'is_admin' => 3,
                    'type' => 'reminder_hour_status',
                    'body' => translate('1 hour left in the booking appointment'),
                    'order_id' => $order->id,
                ]);
                try {
                    // Send firebase notification
                    $device_token = DB::table('device_tokens')->where('user_id', $order->user_id)->select('token')->get()->toArray();
                    $array = array(
                        'device_token' => $device_token,
                        'title' => translate('1 hour left in the booking appointment')
                    );
                    send_firebase_notification($array);
                } catch (\Exception $e) {
                    // dd($e);
                }
            }
            if ($length < 2) {
                // Generate Notification
                \App\Models\Notification::create([
                    'user_id' => $order->user_id,
                    'is_admin' => 3,
                    'type' => 'reminder_day_status',
                    'body' => translate('1 day left in the booking appointment'),
                    'order_id' => $order->id,
                ]);
                try {
                    // Send firebase notification
                    $device_token = DB::table('device_tokens')->where('user_id', $order->user_id)->select('token')->get()->toArray();
                    $array = array(
                        'device_token' => $device_token,
                        'title' => translate('1 day left in the booking appointment')
                    );
                    send_firebase_notification($array);
                } catch (\Exception $e) {
                    // dd($e);
                }
            }
        }
    }
}
