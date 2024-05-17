@section('title', 'sakurun')
@extends('layouts.app')
@section('content')
<div class="app">
    <div class="app-container">
        <livewire:header />
        <main>
            <livewire:pdca-tab-bar />
        </main>
        <livewire:bottom-tab-bar />
    </div>
</div>
@endsection
