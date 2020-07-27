@extends('layouts.admin_layout.admin_layout')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Catalogues</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Products</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
 
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            @if(Session::has('success_message'))
             <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 10px">
               {{ Session::get("success_message") }}
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                 </button>
              </div>
            @endif
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Products</h3>
                <a href="{{ url('admin/add-edit-product') }}" style="max-width: 150px; float:right; display:inline-block;"  class="btn btn-block btn-success">Add Product</a>
              </div>
              <!-- /.card-header -->
            </div>
            <!-- /.card -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Categories</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="products" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Product Code</th>
                    <th>Product Color</th>
                    <th>Product image</th>
                    <th>Category</th>
                    <th>Section</th>
                    <th>Status</th>
                    <th>Actions</th>
                   </tr>
                   </thead>
                   <tbody>
                   @foreach($products as $product)
                   <tr>
                     <td>{{ $product->id }}</td>
                     <td>{{ $product->product_name }}</td>
                     <td>{{ $product->product_code }}</td>                     
                     <td>{{ $product->product_color }}</td>                   
                     <td>
                      <?php $product_image_path = "dashboard/dist/img/product_img/small/".$product->main_image; ?>
                      @if(!empty($product->main_image) && file_exists($product_image_path))
                        <img style="width: 100px;" src="{{ asset('dashboard/dist/img/product_img/small/'.$product->main_image) }}">
                        @else
                        <img style="width: 100px;" src="{{ asset('dashboard/dist/img/product_img/small/no-image.png') }}">

                      @endif
                    </td>
                     <td>{{ $product->category->category_name }}</td>
                     <td>{{ $product->section->name }}</td>
                     <td>
                      @if($product->status==1)
                   <a class="updateProductStatus" id="product-{{  $product->id }}" product_id="{{  $product->id }}" href="javascript:void(0)">Active</a>
                    @else
                    <a class="updateProductStatus" id="product-{{  $product->id }}" product_id="{{  $product->id }}" href="javascript:void(0)">
                     Inactive </a>
                    @endif</td>
                    <td>
                      <a title="Add/Edit Attributes" href="{{ url('admin/add-attributes/'.$product->id) }}"><i class="fas fa-plus"></i></a> &nbsp;&nbsp;
                      <a title="Edit Product" href="{{ url('admin/add-edit-product/'.$product->id) }}"><i class="fas fa-edit"></i></a> &nbsp;&nbsp;
                      <a title="Delete Product" href="javascript:void(0)" class="confirmDelete" record="product" recordid="{{  $product->id }}" <?php /* href="{{ url('admin/delete-product/'.$product->id) }}" */ ?>> <i class="fas fa-trash"></i></a>
                    </td>
                  </tr>
                  @endforeach

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

@endsection