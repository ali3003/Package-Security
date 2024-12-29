<?php

namespace App\Jobs;

use App\Mail\actionMail;
use App\Mail\authEmail;
use App\Mail\LogintoYourAccount;
use App\Mail\reSetPasswordEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmail implements ShouldQueue
{
    use Queueable;
    private $type;
    private $var1;
    private $var2;
    private $var3;
    private $var4;

    /**
     * Create a new job instance.
     */
    public function __construct($type,$var1=null,$var2=null,$var3=null,$var4=null)
    {
        $this->type=$type;
        $this->var1=$var1??null;
        $this->var2=$var2??null;
        $this->var3=$var3??null;
        $this->var4=$var4??null;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->type==='sendCode'){
            Mail::to($this->var1)->send(new authEmail($this->var2, $this->var3));
        }
        elseif ($this->type==='loginEvent'){
            Mail::to($this->var1)->send(new LogintoYourAccount($this->var2, $this->var3,$this->var4));
        }
        elseif ($this->type==='resetPassword'){
            Mail::to($this->var1)->send(new reSetPasswordEmail($this->var2, $this->var3));
        }
        elseif ($this->type==='actionEmail'){
            Mail::to($this->var1)->send(new actionMail($this->var2, $this->var3,$this->var4));
        }
    }
}
