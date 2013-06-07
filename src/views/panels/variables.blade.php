<h2>Variables</h2>

@foreach ($variables as $label => $data)
<div class="data-table">
    <h3>{{ $label }}</h3>
    @if(!empty($data))
        <table class="main">
            @foreach($data as $k => $value)
                <tr>
                    <td>{{ $e($k) }}</td>
                    <td>{{ $e(print_r($value, true)) }}</td>
                </tr>
            @endforeach
        </table>
    @else
        <p class="empty">empty</p>
    @endif
</div>
@endforeach

