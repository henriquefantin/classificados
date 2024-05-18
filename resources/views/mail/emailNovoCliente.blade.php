<h1>Nova solicitação de acesso!</h1>
<p>O cliente {{ $empresa->nome }} deseja anunciar produtos e está aguardando contato.</p>
<br><br>
<h3>Contatos</h3>
@empty($empresa->email)
@else
<p>Email: {{ $empresa->email }}</p>
@endempty
@empty($empresa->telefone)
@else
<p>Telefone: {{ $empresa->telefone }}</p>
@endempty
@empty($empresa->celular)
@else
<p>WhatsApp: {{ $empresa->celular }}</p>
@endempty