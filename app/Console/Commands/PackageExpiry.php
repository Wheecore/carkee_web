<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PackageExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if the package is expired send a notification';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $orders = DB::table('orders')
            ->select('id', 'user_id', DB::raw('(DATE_ADD(`warranty_activation_date`, INTERVAL `battery_expiry_months` MONTH)) as battery_expiry_date'), DB::raw('(DATE_ADD(`installation_completed_date`, INTERVAL `package_expiry_months` MONTH)) as package_expiry_date'))
            ->where('expiry_notification_date', date('Y-m-d'))
            ->where('package_expiry_months', '!=', NULL)
            ->orWhere('warranty_activation_date', '!=', NULL)
            ->get()->toArray();
        foreach ($orders as $order) {
            $days = 0;
            // calculate next notification date
            if ($order->battery_expiry_date) {
                $type = 'battery_expiry';
                $datediff = (strtotime($order->battery_expiry_date) - strtotime(date('Y-m-d')));
                $days = (int) (round($datediff / (60 * 60 * 24)));
            } elseif ($order->package_expiry_date) {
                $type = 'package_expiry';
                $datediff = (strtotime($order->package_expiry_date) - strtotime(date('Y-m-d')));
                $days = (int) (round($datediff / (60 * 60 * 24)));
            }
            if ($days > 0) {
                $text = '';
                $expiry_notification_date = NULL;
                if ($days == 30) {
                    $text = ($type == 'battery_expiry') ? translate('Your battery warranty will expire after 1 month') : translate('Your package will expire after 1 month');
                    $expiry_notification_date = date('Y-m-d', strtotime(date('Y-m-d') . ' +' . ($days - 7) . ' days'));
                } elseif ($days == 7) {
                    $text = ($type == 'battery_expiry') ? translate('Your battery warranty will expire after 1 week') : translate('Your package will expire after 1 week');
                    $expiry_notification_date = date('Y-m-d', strtotime(date('Y-m-d') . ' +' . 5 . ' days'));
                } elseif ($days == 2) {
                    $text = ($type == 'battery_expiry') ? translate('Your battery warranty will expire after 1 day') : translate('Your package will expire after 1 day');
                }
                // dd($expiry_notification_date);
                DB::table('orders')->where('id', $order->id)->update([
                    'expiry_notification_date' => $expiry_notification_date
                ]);
                if ($text != '') {
                    // Generate Notification
                    \App\Models\Notification::create([
                        'user_id' => $order->user_id,
                        'is_admin' => 3,
                        'type' => $type,
                        'body' => $text,
                        'order_id' => $order->id,
                    ]);
                    // Send firebase notification
                    try {
                        $device_token = DB::table('device_tokens')->where('user_id', $order->user_id)->select('token')->get()->toArray();
                        $array = array(
                            'device_token' => $device_token,
                            'title' => $text
                        );
                        send_firebase_notification($array);
                    } catch (\Exception $e) {
                    }
                }
            }
        }
    }
}
