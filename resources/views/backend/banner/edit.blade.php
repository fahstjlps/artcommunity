@extends('adminlte::page')

@section('title', 'TFRD')
@section('css')
@include('backend.layouts.css_fileinput')
@stop
@section('content_header')
<h1 class="pull-left">Banner</h1>
    <div class="pull-right"><a class="d-block btn btn-info" href="{{url('backend/banner')}}"><i class="fa fa-undo"></i> Back</a></div>
@stop

@section('content')
<div class="pull-left col-xs-12" style="margin-top:15px;">
    <div class="box box-warning">
        <div class="box-header">
            <h3 class="box-title">Add Image Banner to Home Page</h3>
        </div><!-- /.box-header -->
        <!-- form start -->
        {{ Form::open(array('url' => 'backend/banner/edit', 'method' => 'post','enctype' => 'multipart/form-data','id'=>'form-validate','data-toggle'=>'validator','role'=>'form')) }}
        {{csrf_field()}}
            <div class="box-body">
                <div class="form-group">
                    <label>Page</label>
                    <select name="page" class="form-control select2" style="width: 100%;">
                        @foreach($pagelist as $page => $value)
                            @if($banner->page_id == $page)
                            <option value="{{$page}}" selected="selected">{{$value}}</option>
                            @else
                            <option value="{{$page}}">{{$value}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input name="title" type="text" class="form-control" id="title" value="{{$banner->title}}"  data-error="กรุณากรอกหัวข้อ" maxlength="255" required>
                    <p class="help-block">Maximum character is 255</p>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input name="description" type="text" class="form-control" id="description" value="{{$banner->description}}" data-error="กรุณากรอกคำอธิบาย" maxlength="255" required>
                    <div class="help-block with-errors"></div>
                    <p class="help-block">Maximum character is 255</p>
                </div>
                <div class="form-group">
                    <label for="keywords">URL</label>
                    <input name="url" type="text" class="form-control" id="url" value="{{$banner->url}}" maxlength="255">
                    <p class="help-block">Maximum character is 255</p>
                </div>
                <div class="form-group">
                    <label for="keywords">Keywords</label>
                    <input name="keywords" type="text" class="form-control" id="keyword"  value="{{$banner->keywords}}" placeholder="images,banner,tfrd,มปอ,...">
                </div>
                <div class="form-group">
                @if(!empty($banner->image))
                    <img style="margin-bottom:15px;max-width:200px;border: solid thin #ddd;" src="{{asset('storage/images/banner')}}/{{$banner->image}}" />
                @endif
                    <label for="">Image</label>
                    <input class="file" type="file" name="image" id="image" data-preview-file-type="text">
                    <p class="help-block">Image type of png,jpg and max size is 2MB.</p>
                </div>
                <div class="form-group">
                @if(!empty($banner->image_mobile))
                    <img style="margin-bottom:15px;max-width:200px;border: solid thin #ddd;" src="{{asset('storage/images/banner')}}/{{$banner->image_mobile}}" />
                @endif
                    <label for="">Image Mobile</label>
                    <input class="file" type="file" name="image_mobile" id="image_mobile" data-preview-file-type="text">
                    <p class="help-block">Image type of png,jpg and max size is 2MB.</p>
                </div>
            </div><!-- /.box-body -->

            <div class="box-footer">
                <input type="hidden" name="id" value="{{$banner->id}}" />
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            {{ Form::close() }}
    </div>
</div>
@stop
@section('js')
@include('backend.layouts.js_fileinput')
<script src="{{ asset('js/validator.js')}}"></script>
<script>
    $('#form-validate').validator().on('submit', function (e) {
        if (e.isDefaultPrevented()) {
            // handle the invalid form...
        } else {
            // everything looks good!
        }
    })
</script>
@stop

