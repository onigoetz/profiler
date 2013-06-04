<h2>Database</h2>

<table class="main">
@foreach ($queries as $query)
    <tr>
        <td class="query {{ (array_key_exists('slow', $query)? $query['slow'] : '') }}">
            <span class="indicator">{{ \Onigoetz\Profiler\Utils::getReadableTime($query['time']) }}</span>
            <pre>{{ $query['sql'] }}</pre>

            @if (array_key_exists('bindings', $query) && !empty($query['bindings']))
            <ol class=sql-bindings>
                @foreach ($query['bindings'] as $value)
                <li>
                    <pre>{{{ $value }}}</pre>
                </li>
                @endforeach
            </ol>
            @endif
        </td>
    </tr>
@endforeach
</table>
