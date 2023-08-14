@extends('layouts.app')
@section('title','Ritual')
@section('pagetitle','Ritual')
@section('sort_name',$data['sort_name'])
@section('content')
<div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">Create Ritual</h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{{url('ritual')}}" title="Back">
              <label><- Back</label>
            </a>
          </li>
        </ol>
      </nav>
    </div>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="POST" action="{{route('ritual.store')}}" enctype='multipart/form-data'>
                    @csrf
                    <div class="form-group col-sm-6">
                        <label for="exampleInputName1">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Name" value="{{old('title')}}">
                        @error('title')
                            <p style="color: red">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="exampleInputEmail3">Description</label>
                        <textarea class="form-control" id="description" name="description" placeholder="Description" rows="5">{{old('description')}}</textarea>
                        @error('description')
                            <p style="color: red">{{$message}}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                    <a href="{{url('ritual')}}" class="btn btn-light">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection