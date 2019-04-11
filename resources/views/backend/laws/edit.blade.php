@extends('adminlte::page')

@section('title', 'TFRD')
@section('css')
@include('backend.layouts.css_fileinput')
<link rel="stylesheet" href="{{ asset('vendor/summernote/summernote-bs4.css') }}">
@stop
@section('content_header')
<h1 class="pull-left">Laws</h1>
    <div class="pull-right"><a class="d-block btn btn-info" href="{{url('backend/laws')}}"><i class="fa fa-undo"></i> Back</a></div>
@stop

@section('content')
<div class="pull-left col-xs-12" style="margin-top:15px;">
    <div class="box box-warning">
        <div class="box-header">
            <h3 class="box-title">Laws Data</h3>
        </div><!-- /.box-header -->
        <!-- form start -->
        {{ Form::open(array('url' => 'backend/laws/edit/'.$laws->id, 'method' => 'post','enctype' => 'multipart/form-data','id'=>'form-validate','data-toggle'=>'validator','role'=>'form')) }}
        {{csrf_field()}}
            
            <div class="box-body">
                @if(!empty($category))
                <div class="form-group">
                    <label for="category">Category</label>
                    <select class="form-control" name="law_cate_id" id="category">
                    @if(!empty($laws->cate->title))
                    <option value="{{$laws->cate->id}}">{{$laws->cate->title}}</option>
                    @endif
                    @foreach($category as $c)
                        @if($laws->cate->id != $c->id)
                        <option value="{{$c->id}}">{{$c->title}}</option>
                        @endif
                    @endforeach
                    </select>
                    <div class="help-block with-errors"></div>
                </div>
                @endif
                <div class="form-group">
                    <label for="title">Title</label>
                    <input name="title" type="text" class="form-control" id="title" value="{{ $laws->title }}" maxlength="255" required>
                    <p class="help-block">Maximum character is 255</p>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <label for="title">Description</label>
                    <input name="description" type="text" class="form-control" id="description" value="{{ $laws->description }}" maxlength="255" required>
                    <p class="help-block">Maximum character is 255</p>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <label for="keywords">Keywords</label>
                    <input name="keywords" type="text" class="form-control" id="keyword" value="{{ $laws->keywords }}">
                </div>
                <div class="form-group">
                    <img style="margin-bottom:15px;max-width:200px;border: solid thin #ddd;" src="{{asset('storage/images/laws/thumb')}}/{{$laws->thumb}}" />
                    <label style="width:100%" for="">Thumb</label>
                    <input class="file" type="file" name="thumb" id="thumb" data-preview-file-type="text">
                    <p class="help-block">Image type of png,jpg and max size is 2MB.</p>
                </div>
                <div class="form-group">
                    <img style="margin-bottom:15px;max-width:200px;border: solid thin #ddd;" src="{{asset('storage/images/laws')}}/{{$laws->image}}" />
                    <label for="">Image</label>
                    <input class="file" type="file" name="image" id="image" data-preview-file-type="text">
                    <p class="help-block">Image type of png,jpg and max size is 2MB.</p>
                </div>
                <div class="form-group">
                    <label for="title">Detail</label>
                    <textarea id="detail" name="detail">
                    {!!$laws->detail ?? ''!!}
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
@include('backend.layouts.js_fileinput')
<script src="{{ asset('vendor/summernote/summernote-bs4.js') }}"></script>
<script src="{{ asset('js/validator.js')}}"></script>
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
            url: "{{url('backend/laws/upload/image')}}",
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(results) {
                $(el).summernote('editor.insertImage', results);
            }
        });
        };
    $('#form-validate').validator().on('submit', function (e) {
        if (e.isDefaultPrevented()) {
            // handle the invalid form...
        } else {
            // everything looks good!
        }
    });
</script>
    
@stop