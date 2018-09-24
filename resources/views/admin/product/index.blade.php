@extends('admin.layout')

@section('content')

<div class="container">
  <div class="large-panel">
    <div class="panel-heading">
      <label class="heading">PRODUCT MANAGEMENT</label>
    </div>
    <div class="panel-body">
      <a href="{{ route('adminHome') }}"><< BACK</a>
    </div>
    <div class="panel-body">
      <table>
        <tr>
          <td>id</td>
          <td>category</td>
          <td>sub</td>
          <td>type</td>
          <td>name</td>
          <td>price</td>
          <td>discount</td>
          <td>view</td>
          <td>amount</td>
          <td>edit</td>
        </tr>
        @foreach ($products as $product)
          <tr>
            <td>{{$product->id}}</td>
            <td>{{$product->category->name}}</td>
            <td>{{$product->subcategory->name}}</td>
            <td>{{$product->type->name}}</td>
            <td>{{$product->name}}</td>
            <td>{{number_format($product->price)}}</td>
            <td>{{$product->discount_price ? number_format($product->discount_price) : 'no'}}</td>
            <td>{{number_format($product->view_count)}}</td>
            <td>{{$product->amount}}</td>
            <td>
              <a href="{{ route('productEdit', ['product' => $product->uid]) }}"><i class="fas fa-pen"></i></a>
            </td>
          </tr>
        @endforeach
      </table>
    </div>

  </div>
</div>

@endsection
