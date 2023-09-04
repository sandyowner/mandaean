@extends('layouts.app')
@section('title','Color')
@section('pagetitle','Color')
@section('sort_name',$data['sort_name'])
@section('content')
<div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">Edit Color</h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{{url('color')}}" title="Back">
              <label><- Back</label>
            </a>
          </li>
        </ol>
      </nav>
    </div>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="POST" action="{{route('color.update',$data['color']->id)}}" enctype='multipart/form-data'>
                    @csrf
                    @method('PUT')
                    <h4 align="center">English Language</h4><br/>
                    <div class="form-group col-sm-12">
                        <label for="exampleInputName1">Color Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Color Name" value="{{old('name',$data['name']->name)}}">
                        @error('name')
                            <p style="color: red">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="exampleInputEmail3">Color Code</label>
                        <textarea class="form-control" id="color" name="color" placeholder="Color Code" rows="3">{{old('color',$data['color']->color)}}</textarea>
                        @error('color')
                            <p style="color: red">{{$message}}</p>
                        @enderror
                    </div>

                    <h4 align="center">Arabic Language</h4><br/>
                    <div class="form-group col-sm-12">
                        <label for="exampleInputName1">Color Name</label>
                        <input type="text" class="form-control" id="ar_name" name="ar_name" placeholder="Color Name" value="{{old('ar_name',$data['color']->ar_name)}}">
                        @error('ar_name')
                            <p style="color: red">{{$message}}</p>
                        @enderror
                    </div>

                    <h4 align="center">Persian Language</h4><br/>
                    <div class="form-group col-sm-12">
                        <label for="exampleInputName1">Color Name</label>
                        <input type="text" class="form-control" id="pe_name" name="pe_name" placeholder="Color Name" value="{{old('pe_name',$data['color']->pe_name)}}">
                        @error('pe_name')
                            <p style="color: red">{{$message}}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                    <a href="{{url('color')}}" class="btn btn-light">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<script type="text/javascript">
    $('#description,#other_info,#ar_description,#ar_other_info,#pe_description,#pe_other_info').summernote({
        height: 300
    });
</script>
@endsection