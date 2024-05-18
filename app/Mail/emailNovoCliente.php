<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class emailNovoCliente extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $empresa;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user = Auth::user();

        $sql  = " SELECT nome, email, telefone, celular ";
        $sql .= " FROM empresa E ";
        $sql .= " WHERE id = " . $this->user->codEmpresa;
        $sql .= " LIMIT 1 ";
        $rsEmpresa = DB::select($sql);

        $this->empresa = $rsEmpresa[0];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Nova solicitação de acesso.');
        $this->to('henrique.fantin.ns@gmail.com','João');
        return $this->view('mail.emailNovoCliente', ['empresa' => $this->empresa]);
    }
}
