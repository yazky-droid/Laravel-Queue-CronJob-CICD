@component('mail::message')
{!! $header !!}
<h1>Hallo {{ $name }},</h1>
{{-- <p> We have been receive your order. Thank you for order in {{ config('app.name') }}</p>
<p>Please, finish your payment before <b>{{ $expire }}</b></p>. <br><p>So we can process it soon.</p> --}}
{!! $content !!}
Thank you for order in<br>
<h3>{{ config('app.name') }}</h3>
@endcomponent
