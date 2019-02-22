@extends('adminlte::page')

@section('title', 'TFRD')

@section('content_header')
<h1>
Home Page
</h1>
<ol class="breadcrumb">
    <li><i class="fa fa-dashboard"></i> About</li>
    <li class="active"><i class="fa fa-dashboard"></i> History</li>
</ol>
@stop
@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/summernote/summernote-bs4.css') }}">
    @include('backend.layouts.css_fileinput')
@section('content')
<section class="main-intro box">
    <div class="col-xs-12">
        {{ Form::open(array('url' => 'backend/about/history/'.$history->id, 'method' => 'post','enctype' => 'multipart/form-data')) }}
        {{csrf_field()}}
        <div class="form-group">
            <img class="center-block pull-left" style="margin-bottom:15px; margin-top:15px;" src="{{asset('storage/images/about/history')}}/{{$history->image}}" />
            <label style="width:100%" for="">Image</label>
            <input class="file" type="file" name="image" id="image" data-preview-file-type="text" required>
            <p class="help-block">Image type of png,jpg and max size is 2MB.</p>
        </div>
        <div class="form-group">
            <label for="title">Detail</label>
            <textarea id="detail" name="detail">
            {!!$history->detail ?? ''!!}
            </textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Submit</button>
        {{ Form::close() }}
    </div>
</section>
@stop
@section('js')
    @include('backend.layouts.js_fileinput')
    <script src="{{ asset('vendor/summernote/summernote-bs4.js') }}"></script>
    <script>
        $("#detail").summernote({
            placeholder: 'Detail...',
                  height: 500,
                   callbacks: {
                  onImageUpload : function(files, editor, welEditable) {
                      sendFile(files[0], this);
                  }
              }
          });
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
              }
          });
          function sendFile(file, el) {
            var form_data = new FormData();
            form_data.append('file', file);
            var CSRF_TOKEN = $('input[name="_token"]').attr('value');

            $.ajax({
                type: 'post',
                url: "{{url('backend/about/history/detail')}}",
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(results) {
                    $(el).summernote('editor.insertImage', results);
                }
            });
          };
    </script>
@stop