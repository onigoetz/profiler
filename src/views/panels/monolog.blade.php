<h2>Logs</h2>

@if (empty($logs))
<h3>This panel has no log items.</h3>
@else
<table class="op-table">
    @foreach ($logs as $log)
    <tr><td>{{ $logger->getLevelName($log['level']) }}</td><td> {{ nl2br(print_r($log['message'], true)) }}</td></tr>
    @endforeach
</table>
@endif
