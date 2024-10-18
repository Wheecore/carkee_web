<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use PDF;

class InvoiceEmailManager extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $array;

    public function __construct($array)
    {
        $this->array = $array;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = array('order' => $this->array['order']);
        $type = '';
        if($this->array['order']->order_type == 'N'){
            $view = 'backend.invoices.invoice';
        }
        else{
            if($this->array['order']->order_type == 'B'){
                $type = 'battery';
            }
            else if($this->array['order']->order_type == 'P'){
                $type = 'petrol';
            }
            else if($this->array['order']->order_type == 'T'){
                $type = 'tyre';
            }
            else if($this->array['order']->order_type == 'CW'){
                $type = 'car_wash';
            }
            $view = 'backend.invoices.emergency-order-invoice';
        }
        $pdf = PDF::loadView($view, [
            'order' => $this->array['order'],
            'type' => $type,
            'font_family' => $this->array['font_family'],
            'direction' => $this->array['direction'],
            'text_align' => $this->array['text_align'],
            'not_text_align' => $this->array['not_text_align']
        ]);
        return $this->view($this->array['view'])
            ->from($this->array['from'], env('MAIL_FROM_NAME'))
            ->subject($this->array['subject'])
            ->with($data)
            ->attachData($pdf->output(), 'order-'.$this->array['order']->code.'.pdf', ['mime' => 'application/pdf']);
    }
}
