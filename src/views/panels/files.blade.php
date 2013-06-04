<h2>Files</h2>

@if (empty($files))
    <h3>No loaded files.</h3>
@else
    <table class="main">
    @foreach ($files as $file)
        <tr><td><span class="indicator">{{ $file['size'] }}</span> {{ $file['name'] }}</td></tr>
    @endforeach
    </table>
@endif
