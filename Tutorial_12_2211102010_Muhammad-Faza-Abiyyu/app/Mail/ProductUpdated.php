<?php

namespace App\Mail;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $product;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Produk Diperbarui: ' . $this->product->nama)
                    ->view('emails.product-updated');
    }
}