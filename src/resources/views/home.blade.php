@extends('templates.app')

@section('content')
    <div class="homepage">
        <h1>Welcome</h1>
        @include('templates.sample', ['title' => 'sample'])
    </div>
@overwrite

