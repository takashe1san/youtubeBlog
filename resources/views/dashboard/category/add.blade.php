@extends('dashboard.layouts.layout')
@section('body')
@error('message')
    {{$message}}
@enderror
<form method="POST" action="{{ route('dashboard.category.store')}}" enctype="multipart/form-data">
    @csrf
    @method('post')
    <div class="row mb-3">
        <label for="img" class="col-md-4 col-form-label text-md-end">{{ __('words.categoryImage') }}</label>

        <div class="col-md-6">
            <input id="img" type="file" class="form-control @error('name') is-invalid @enderror" name="image" autofocus>
            @error('image')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    {{-- <div class="row mb-3">
        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('words.name') }}</label>

        <div class="col-md-6">
            <input id="name" type="text" class="form-control @error('email') is-invalid @enderror" name="name"  required autocomplete="name">
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div> --}}

    <div class="row mb-3">
        <label for="parent" class="col-md-4 col-form-label text-md-end">{{ __('words.categoryType') }}</label>

        <div class="col-md-6">
            <select id="parent" name="parent" class="@error('status') is-invalid @enderror">
                <option value="">{{__('words.mainCategory')}}</option>
                @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{$category->title}}</option>
                @endforeach
            </select>
            @error('status')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="card">
        <div class="card-header">
          <strong>{{__('words.translations')}}</strong>
        </div>
        <div class="card-block">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            @foreach (config('app.languages') as $key => $lang)
                <li class="nav-item">
                  <a href="#{{$key}}" class="nav-link @if($loop->index == 0) active @endif" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">{{$lang}}</a>
                </li>
            @endforeach
            <div class="tab-content" id="myTabContent">
              @foreach (config('app.languages') as $key => $lang)
                <div class="tab-pane fade @if($loop->index == 0) show active in @endif" id="{{$key}}" role="tabpanel" aria-labelledby="home-tab">
                  <div class="form-group mt-2 col-md-12">
                    <label>{{__('words.title')}}</label>
                    <input type="text" name="{{$key}}[title]" class="form-control">
                  </div>
                  
                  <div class="form-group col-md-12">
                    <label>{{__('words.content')}}</label>
                    <textarea name="{{$key}}[content]" class="form-control" id="" cols="30" rows="10"></textarea>
                  </div> 
                </div>
              @endforeach
            </div>
          </ul>
          <div class="text-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light " id="btn-submit">{{__('words.save')}}</button>
          </div>
        </div>
      </div>
</form>
@endsection