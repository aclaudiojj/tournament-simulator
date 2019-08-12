@extends('template')

@section('content')

<div>
    <form action="{{ route('simulator') }}" method="POST">
        @csrf

        <button type="submit">Simulate!</button>
    </form>
</div>

@endsection