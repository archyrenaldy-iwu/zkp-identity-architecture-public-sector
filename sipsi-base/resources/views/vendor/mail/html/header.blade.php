@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
{{-- @if (trim($slot) === 'SISE') --}}
<img src="{{ asset('img/logo2.png') }}" class="logo" alt="SISE Logo">
{{-- @else
{{ $slot }}
@endif --}}
</a>
</td>
</tr>
