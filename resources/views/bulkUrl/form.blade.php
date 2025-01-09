{{-- resources/views/bulkUrl/form.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>Bulk URL Upload</h1>
    <form action="{{ url('bulk-url/upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="file">Upload CSV File:</label>
        <input type="file" name="file" accept=".csv" required>
        <button type="submit">Upload</button>
    </form>
@endsection
