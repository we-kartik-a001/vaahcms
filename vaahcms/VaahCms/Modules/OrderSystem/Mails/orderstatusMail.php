<?php  namespace VaahCms\Modules\OrderSystem\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use VaahCms\Modules\OrderSystem\Models\order;

class orderstatusMail extends Mailable {

    use Queueable, SerializesModels;

      public $order;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(order $order)
    {
        $this->order = $order;
    }
    
   public function envelope():Envelope
    {
        return new Envelope(
            subject: 'Order created - #' . ($this->order->id ?? ''),
        );
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
   public function build()
    {
        return $this->view('ordersystem::emails.orderstatus')
                    ->with(['order' => $this->order]);
    }
}
