@foreach ($data as $item)
    {{ $item->name }} - DB limit {{ $item->database_limit }}
@endforeach