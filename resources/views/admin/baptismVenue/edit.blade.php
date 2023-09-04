@extends('layouts.app')
@section('title','Baptism Venue')
@section('pagetitle','Baptism Venue')
@section('sort_name',$data['sort_name'])
@section('content')
<div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">Edit Baptism Venue</h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{{url('baptism-venue')}}" title="Back">
              <label><- Back</label>
            </a>
          </li>
        </ol>
      </nav>
    </div>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="POST" action="{{route('baptism-venue.update',$data['venue']->id)}}" enctype='multipart/form-data'>
                    @csrf
                    @method('PUT')
                    <h4 align="center">English Language</h4><br/>
                    <div class="form-group col-sm-12">
                        <label for="exampleInputName1">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{old('name',$data['venue']->name)}}">
                        @error('name')
                            <p style="color: red">{{$message}}</p>
                        @enderror
                    </div>

                    <h4 align="center">Arabic Language</h4><br/>
                    <div class="form-group col-sm-12">
                        <label for="exampleInputName1">Name</label>
                        <input type="text" class="form-control" id="ar_name" name="ar_name" placeholder="Name" value="{{old('ar_name',$data['venue']->ar_name)}}">
                        @error('ar_name')
                            <p style="color: red">{{$message}}</p>
                        @enderror
                    </div>

                    <h4 align="center">Persian Language</h4><br/>
                    <div class="form-group col-sm-12">
                        <label for="exampleInputName1">Name</label>
                        <input type="text" class="form-control" id="pe_name" name="pe_name" placeholder="Name" value="{{old('pe_name',$data['venue']->pe_name)}}">
                        @error('pe_name')
                            <p style="color: red">{{$message}}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                    <a href="{{url('baptism-venue')}}" class="btn btn-light">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection