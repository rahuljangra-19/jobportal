@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
    <img src="https://www.wittytalk.me/jobportal/public/assets/images/logo.png" class="logo" alt="Laravel Logo">
{{-- @if (trim($slot) === 'Laravel')
@else
{{ $slot }}
@endif --}}
</a>
</td>
</tr>
