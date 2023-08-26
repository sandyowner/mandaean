@extends('layouts.app')
@section('title','Order')
@section('pagetitle','Order')
@section('sort_name',$data['sort_name'])
@section('content')
<div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">View Order</h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{{url('orders')}}" title="Back">
              <label><- Back</label>
            </a>
          </li>
        </ol>
      </nav>
    </div>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                
            </div>
        </div>
    </div>
</div>
@endsection