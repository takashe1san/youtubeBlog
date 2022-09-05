@extends('dashboard.layouts.layout')
@section('body')
@error('message')
    {{$message}}
@enderror
<form method="POST" action="{{ route('dashboard.users.update', $user->id) }}">
    @csrf
    @method('put')
    <div class="row mb-3">
        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('words.name') }}</label>

        <div class="col-md-6">
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('words.email') }}</label>

        <div class="col-md-6">
            <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('words.status') }}</label>

        <div class="col-md-6">
            <select name="status" class="@error('status') is-invalid @enderror">
                <option value="">{{__('words.notSelected')}}</option>
                <option value="admin" @selected($user->status == 'admin')>{{__('words.admin')}}</option>
                <option value="writer" @selected($user->status == 'writer')>{{__('words.writer')}}</option>
            </select>
            @error('status')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                {{ __('words.update') }}
            </button>
        </div>
    </div>
</form>
@endsection