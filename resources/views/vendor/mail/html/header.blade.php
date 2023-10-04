<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
    @if($email_header_logo)
        <img src="{{$email_header_logo}}" class="logo">
    @else
        {{ $slot }}
    @endif
</a>
</td>
</tr>
