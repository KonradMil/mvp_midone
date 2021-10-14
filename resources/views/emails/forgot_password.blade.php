<h4>{{ $email }}</h4>
<p>Czy chcesz zmienić hasło?</p>
<a href="{{env('APP_URL')}}/reset-password/{{$token}}" class="es-button" target="_blank" style="mso-style-priority:100 !important;text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;font-size:22px;color:#FFFFFF;border-style:solid;border-color:#5e50ac;border-width:10px 20px;display:inline-block;background:#5e50ac;border-radius:0px;font-weight:bold;font-style:normal;line-height:26px;width:auto;text-align:center">Zresetuj hasło</a>
<br />
<p><i>Ten mail został wygenerowany automatycznie z naszego systemu. Prosimy na niego nie odpowiadać.</i></p>
