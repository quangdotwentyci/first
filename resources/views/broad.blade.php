@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <example-component></example-component>
            {{$userId}}
            <task :userId = "{{ $userId }}" ></task>
        </div>
    </div>
</div>
@endsection
