<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Candidatos;

class LeadsListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    protected $candidatos;

    public function __construct(Candidatos $candidatos)
    {
        $this->candidatos = $candidatos;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        cache()->fotget('leads');

        $leads = Candidatos::all();

        cache()->forever('leads', $leads);
    }
}
