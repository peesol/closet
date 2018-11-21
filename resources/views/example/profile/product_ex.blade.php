@extends('example.layout_ex')
@section('title')
{{'ตัวอย่างหน้าร้าน - '}}
@endsection

@section('scripts')
<script type="text/javascript">
  $('.shop-carousel').slick();
</script>
@endsection

@section('content')

<div class="container">
  <div class="medium-panel">
    @include('example.profile._header')
    @include('example.profile._shopnav', ['current' => 'product'])
    <div class="panel-heading-alt">
      <h3 class="no-margin font-grey">สินค้า&nbsp;(6)</h3>
    </div>
    <div class="panel-body thumbnail-grid">
    <div class="products-wrap">
        <div class="products-img">
            <a href="/product/p_5bebb38a5dc41"><img src="https://s3-ap-southeast-1.amazonaws.com/images.closet.com/product/thumbnail/example/1.jpeg" alt="example/1.jpeg" class="products-img-thumb"></a> <span class="sale top-right"></span> <span class="thumb-price-discount bottom-left"><s>1,600</s><br>
          1,200฿
        </span></div>
        <div class="details"><a href="/product/p_5bebb38a5dc41" class="link-text product-name">สินค้า1</a>
            <p class="product-p">
                ราคา&nbsp;<s>1,600฿</s>&nbsp;
                <font class="font-green">1,200฿</font></p>
        </div>
    </div>
    <div class="products-wrap">
        <div class="products-img">
            <a href="/product/p_5bebb38a5dc42"><img src="https://s3-ap-southeast-1.amazonaws.com/images.closet.com/product/thumbnail/example/2.jpeg" alt="example/2.jpeg" class="products-img-thumb"></a> <span class="sale top-right"></span> <span class="thumb-price-discount bottom-left"><s>990</s><br>
          500฿
        </span></div>
        <div class="details"><a href="/product/p_5bebb38a5dc42" class="link-text product-name">สินค้า2</a>
            <p class="product-p">
                ราคา&nbsp;<s>990฿</s>&nbsp;
                <font class="font-green">500฿</font></p>
        </div>
    </div>
    <div class="products-wrap">
        <div class="products-img">
            <a href="/product/p_5bebb38a5dc43"><img src="https://s3-ap-southeast-1.amazonaws.com/images.closet.com/product/thumbnail/example/3.jpeg" alt="example/3.jpeg" class="products-img-thumb"></a> <span class="price bottom-left">99฿</span></div>
        <div class="details"><a href="/product/p_5bebb38a5dc43" class="link-text product-name">สินค้า3</a>
            <p class="product-p">ราคา&nbsp;99฿</p>
        </div>
    </div>
    <div class="products-wrap">
        <div class="products-img">
            <a href="/product/p_5bebb38a5dc44"><img src="https://s3-ap-southeast-1.amazonaws.com/images.closet.com/product/thumbnail/example/4.jpeg" alt="example/4.jpeg" class="products-img-thumb"></a> <span class="price bottom-left">500฿</span></div>
        <div class="details"><a href="/product/p_5bebb38a5dc44" class="link-text product-name">สินค้า4</a>
            <p class="product-p">ราคา&nbsp;500฿</p>
        </div>
    </div>
    <div class="products-wrap">
        <div class="products-img">
            <a href="/product/p_5bebb38a5dc45"><img src="https://s3-ap-southeast-1.amazonaws.com/images.closet.com/product/thumbnail/example/5.jpeg" alt="example/5.jpeg" class="products-img-thumb"></a> <span class="price bottom-left">1,290฿</span></div>
        <div class="details"><a href="/product/p_5bebb38a5dc45" class="link-text product-name">สินค้า5</a>
            <p class="product-p">ราคา&nbsp;1,290฿</p>
        </div>
    </div>
    <div class="products-wrap">
        <div class="products-img">
            <a href="/product/p_5bebb38a5dc45"><img src="https://s3-ap-southeast-1.amazonaws.com/images.closet.com/product/thumbnail/example/6.jpeg" alt="example/6.jpeg" class="products-img-thumb"></a> <span class="price bottom-left">350฿</span></div>
        <div class="details"><a href="/product/p_5bebb38a5dc45" class="link-text product-name">สินค้า6</a>
            <p class="product-p">ราคา&nbsp;350฿</p>
        </div>
    </div>
</div>
  </div>
</div>
<style media="screen">
  img {
    width: 100%;
  }
  .alert-box {
    font-family: 'Arial', sans-serif !important;
    margin: 0 10px;
  }
  sub {
    font-family: 'Arial', sans-serif !important;
  }
</style>
@endsection
