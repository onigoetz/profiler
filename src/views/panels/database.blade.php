<h2>Database</h2>

@if (count($queries))
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

    <h3>Duplicates</h3>
    @if (count($duplicates))
        <table class="main">
            @foreach ($duplicates as $sql => $query)
            <tr>
                <td class="query {{ (array_key_exists('slow', $query)? $query['slow'] : '') }}">
                    <span class="indicator">{{ $query['qty'] }}&times; (Total {{ \Onigoetz\Profiler\Utils::getReadableTime($query['time']) }})</span>
                    <pre>{{ $sql }}</pre>
                </td>
            </tr>
            @endforeach
        </table>
    @else
        <p class=empty>No duplicated queries, good job !</p>
    @endif

@else
    <p class=empty>No queries on this page</p>
@endif
