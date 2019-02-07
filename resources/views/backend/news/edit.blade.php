@extends('adminlte::page')

@section('title', 'TFRD')
@section('css')
<link rel="stylesheet" href="{{ asset('css/image_preview.css')}}">
<link rel="stylesheet" href="{{ asset('vendor/summernote/summernote-bs4.css') }}">
@stop
@section('content_header')
<h1 class="pull-left">News and activities</h1>
    <div class="pull-right"><a class="d-block btn btn-info" href="{{url('backend/news')}}"><i class="fa fa-undo"></i> Back</a></div>
@stop

@section('content')
<div class="pull-left col-xs-12" style="margin-top:15px;">
    <div class="box box-warning">
        <div class="box-header">
            <h3 class="box-title">Add Image Banner to Home Page</h3>
        </div><!-- /.box-header -->
        <!-- form start -->
        {{ Form::open(array('url' => 'backend/news/edit/'.$news->id, 'method' => 'post','enctype' => 'multipart/form-data')) }}
        {{csrf_field()}}
            
            <div class="box-body">
                <div class="form-group">
                    <label for="category">Category</label>
                    <select class="form-control" name="cate_id" id="category">
                    <option value="{{$news->cate->id}}">{{$news->cate->title}}</option>
                    @foreach($category as $c)
                        @if($news->cate->id != $c->id)
                        <option value="{{$c->id}}">{{$c->title}}</option>
                        @endif
                    @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input name="title" type="text" class="form-control" id="title" value="{{ $news->title }}" required>
                </div>
                <div class="form-group">
                    <label for="title">Description</label>
                    <input name="description" type="text" class="form-control" id="description" value="{{ $news->description }}" required>
                </div>
                <div class="form-group">
                    <label for="keywords">Keywords</label>
                    <input name="keywords" type="text" class="form-control" id="keyword" value="{{ $news->keywords }}">
                </div>
                <div class="form-group">
                    <img style="margin-bottom:15px;" src="{{asset('storage/images/news/thumb')}}/{{$news->thumb}}" />
                    <div class="custom-preview" style="width: 300px">
                        <label class="custom-preview-label" for="">Thumb</label>
                        <input class="custom-preview-input" type="file" name="thumb" id="thumb" preview="thumb-preview" >
                    </div>
                    <p class="help-block">Image type of png,jpg and max size is 2MB.</p>
                    <div class="preview" id="thumb-preview"></div>
                </div>
                <div class="form-group">
                    <img style="margin-bottom:15px;" src="{{asset('storage/images/news')}}/{{$news->image}}" />
                    <div class="custom-preview" style="width: 300px">
                        <label class="custom-preview-label" for="">Image</label>
                        <input class="custom-preview-input" type="file" name="image" id="image" preview="image-preview">
                    </div>
                    <p class="help-block">Image type of png,jpg and max size is 2MB.</p>
                    <div class="preview" id="image-preview"></div>
                </div>
                <div class="form-group">
                    <label for="title">Detail</label>
                    <textarea id="detail" name="detail">
                    {!!$news->detail ?? ''!!}
                    </textarea>
                </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            {{ Form::close() }}
    </div>
</div>
@stop
@section('js')
<script src="{{ asset('js/image_preview.js') }}"></script>
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
                url: "{{url('backend/news/upload/image')}}",
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