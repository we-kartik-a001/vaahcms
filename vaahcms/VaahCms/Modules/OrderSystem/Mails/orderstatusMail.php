<?php  namespace VaahCms\Modules\OrderSystem\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class orderstatusMail extends Mailable {

    use Queueable, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }
    
   public function envelope():Envelope
    {
        return new Envelope(
            subject: 'Order Status Updated - #' . ($this->order->id ?? ''),
        );
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function build()
    {
        return $this->view('ordersystem::emails.orderstatus');
    }

}
