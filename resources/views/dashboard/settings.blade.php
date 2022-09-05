@extends('dashboard.layouts.layout')
@section('body')
  <form class="form-horizontal" action="{{route('dashboard.settings.update', $setting)}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card">
      <div class="card-header">
        <strong>{{__('words.settings')}}</strong>
      </div>
      <div class="card-block">
        <div class="col-sm-6">
          <div class="form-group">
            <img src="{{asset($setting->logo)}}" alt="{{__('words.logo')}}" width="100">
          </div>
          <div class="form-group">
            <label class="control-label col-sm-4">{{__('words.logo')}}</label>
            <div class="col-sm-8">
              <input type="file" name="logo" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <img src="{{asset($setting->favicon)}}" alt="{{__('words.favicon')}}" width="100">
          </div>
          <div class="form-group">
            <label class="control-label col-sm-4">{{__('words.favicon')}}</label>
            <div class="col-sm-8">
              <input type="file" name="favicon" class="form-control">
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <label class="control-label col-sm-4">{{__('words.facebook')}}</label>
            <div class="col-sm-8">
              <input type="text" name="facebook" class="form-control" value="{{$setting->facebook}}">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-4">{{__('words.instagram')}}</label>
            <div class="col-sm-8">
              <input type="text" name="instagram" class="form-control" value="{{$setting->instagram}}">
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <label class="control-label col-sm-4">{{__('words.twitter')}}</label>
            <div class="col-sm-8">
              <input type="text" name="twitter" class="form-control" value="{{$setting->twitter}}">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-4">{{__('words.email')}}</label>
            <div class="col-sm-8">
              <input type="text" name="email" class="form-control" value="{{$setting->email}}">
            </div>
          </div>
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
                    <input type="text" name="{{$key}}[title]" class="form-control" value="{{$setting->translate($key)->title}}">
                  </div>
                  
                  <div class="form-group col-md-12">
                    <label>{{__('words.content')}}</label>
                    <textarea name="{{$key}}[content]" class="form-control" id="" cols="30" rows="10">{{$setting->translate($key)->content}}</textarea>
                  </div>
                  
                  <div class="form-group col-md-12">
                    <label>{{__('words.address')}}</label>
                    <input type="text" name="{{$key}}[address]" class="form-control" value="{{$setting->translate($key)->address}}">
                  </div> 
                </div>
              @endforeach
            </div>
          </ul>
          <div class="text-center">
            <button class="btn btn-primary waves-effect waves-light " id="btn-submit">{{__('words.save')}}</button>
          </div>
        </div>
      </div>
    </div>
  </form>
@endsection