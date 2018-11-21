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
    @include('example.profile._shopnav', ['current' => 'review'])
    <div class="panel-heading-alt">
      <label class="heading">รีวิว</label>
    </div>
    <div class="alert-box help">
      ผู้ที่ซื้อสินค้า และ <u class="arial">ได้รับสินค้าแล้ว</u> เท่านั้นถึงจะสามารถรีวิวร้านค้าได้<br>
      **ถ้าคุณแจ้งผู้ซื้อว่าส่งสินค้าแล้ว ผู้ซื้อสามารถให้คะแนนได้ทันที
    </div>
    <div class="panel-body-alt relative">
        <div>
            <div class="total-rating">
                <h2><i class="fas fa-star"></i>&nbsp;<span>70%</span></h2></div>
            <div class="review-wrapper">
                <label><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></label><a class="text-nowrap">ผู้ซื้อ 1</a>
                <p>ส่งตรงเวลามาก สินค้าก็ดี</p>
            </div>
            <div class="review-wrapper">
                <label><i class="fas fa-star"></i><i class="fas fa-star"></i></label><a class="text-nowrap">ผู้ซื้อ 2</a>
                <p>บริการแย่มาก ของที่สั่งก็ไม่ถูกต้อง</p>
            </div>
        </div>
    </div>
  </div>
</div>
</div>
@endsection
