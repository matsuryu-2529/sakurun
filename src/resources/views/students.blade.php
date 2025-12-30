@section('title', 'sakurun')
@extends('layouts.app')
@section('content')
<div class="app">
    <div class="app-container">
        <livewire:students.header />
        <main>
            <livewire:students.content />
        </main>
        <livewire:students.bottom-tab-bar />
    </div>
</div>
@endsection
