@section('title', 'sakurun | teacher')
@extends('layouts.teacher')
@section('content')
    <livewire:teachers.header />
    <livewire:teachers.detail :user-id="$userId" :year="$year" />
@endsection
