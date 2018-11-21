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
    @include('example.profile._shopnav', ['current' => 'collection'])
    <div class="panel-heading-alt">
      <label class="full-label heading">คอลเล็คชั่น</label>
    </div>
    <div class="alert-box help">
      ถ้าคอลเล็คชั่นเป็นส่วนตัว คนอื่นจะไม่เห็นยกเว้นคุณซึ่งเป็นเจ้าของ แต่คุณยังสามารถแชร์ลิ้งค์เพื่อให้คนอื่นดูได้อยู่<br>
      คุณเท่านั้นที่สามารถลบหรือแก้ไขคอลเล็คชั่นได้ คนอื่นจะไม่เห็น <i class="fas fa-pen"></i> และ <i class="fas fa-trash-alt"></i>
    </div>
    <div class="panel-body-alt relative">
    <div class="margin-10-bottom">
        <button class="orange-btn normal-sq open">สร้างคอลเล็คชั่น +</button>
    </div>
    <div class="sub-panel shadow-1 margin-10-top not-display">
      <div class="form-group">
          <label class="full-label">ชื่อ</label>
          <input required="required" type="text" class="form-input">
      </div>
      <div class="form-group">
          <label class="full-label">รายละเอียด</label>
          <input type="text" class="form-input" placeholder="ไม่ต้องมีก็ได้">
      </div>
      <div class="form-group">
          <label class="full-label">ใครดูได้</label>
          <select required="required" class="select-input">
              <option value="public">สาธาณะ</option>
              <option value="private">ส่วนตัว</option>
          </select>
      </div>
      <div class="align-right padding-15-vertical" style="padding-bottom: 5px;">
          <button class="orange-btn normal-sq">สร้าง</button>
      </div>
    </div>
    <div class="thumbnail-grid padding-30-vertical">
        <div class="collection-wrap">
            <div class="products-img">
                <div class="thumb-title"><a href="/collection/col5bf5406a6052f1" class="link-text">คอลเล็คชั่น 1</a></div>
                <a href="/collection/col5bf5406a6052f1"><img src="https://s3-ap-southeast-1.amazonaws.com/images.closet.com/collection/thumbnail/default.jpg" class="products-img-thumb"></a> <i class="align-bot-right fa-2x fa-eye-slash fa-inverse far" style="display: none;"></i></div>
            <div class="align-right padding-5">
                <button class="flat-btn"><i class="fas fa-pen"></i></button>
                <button class="flat-btn delete"><i class="fas fa-trash-alt"></i></button>
            </div>
        </div>
        <div class="collection-wrap">
            <div class="products-img">
                <div class="thumb-title"><a href="/collection/col5bf54075c029a1" class="link-text">คอลเล็คชั่น 2</a></div>
                <a href="/collection/col5bf54075c029a1"><img src="https://s3-ap-southeast-1.amazonaws.com/images.closet.com/collection/thumbnail/default.jpg" class="products-img-thumb"></a> <i class="align-bot-right fa-2x fa-eye-slash fa-inverse far"></i></div>
            <div class="align-right padding-5">
                <button class="flat-btn"><i class="fas fa-pen"></i></button>
                <button class="flat-btn delete"><i class="fas fa-trash-alt"></i></button>
            </div>
        </div>
    </div>
</div>


</div>
  </div>
  <script type="text/javascript">
  $('.open').click(function () {
    $('.sub-panel').toggleClass('not-display')
  });
  </script>
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
