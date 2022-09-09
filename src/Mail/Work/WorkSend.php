<?php

namespace Sty\Hutton\Mail\Work;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WorkSend extends Mailable
{
    use Queueable, SerializesModels;

    public $week;

    public $pdf;

    public function __construct($week,$pdf)
    {
        $this->week = $week;

        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->subject('Joiner Weekly Work')
            ->markdown('Hutton::emails.sendWork')
            ->with(['week'=>$this->week])
            ->attachData($this->pdf,'joiner-weekly-work.pdf');
    }
}
