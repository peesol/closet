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
    @include('example.profile._shopnav', ['current' => 'home'])

    <div class="panel-body" id="full-line">
      <p>คำอธิบายร้านของคุณอยู่ตรงนี้</p>
    </div>
    <div class="alert-box help margin-10-top">
      คุณสามารถเพิ่มช่องทางติดต่อได้<br>
      <sub>social network, โทรศัพท์, ที่อยู่ หรือเว็บไซต์</sub>
    </div>
    <div class="padding-10">
      <button class="flat-btn contact-btn">ช่องทางการติดต่อ&nbsp;<i class="fas fa-caret-down"></i>&nbsp;(คลิกเพื่อดู)</button>
      <div class="contacts not-display">
        <table class="c-table">
            <tr>
                <td class="center s-cell no-border"><i class="contact-btn facebook fab fa-facebook"></i></td>
                <td class="no-border"><a class="link-text font-bold arial">Facebook ใส่ลิ้งค์หรือไม่ก็ได้</a>
                    <label class="font-grey font-light arial" style="display: none;">Facebook</label>
                </td>
            </tr>
            <tr>
                <td class="center s-cell no-border"><i class="contact-btn phone fas fa-phone"></i></td>
                <td class="no-border"><a class="link-text font-bold arial" style="display: none;">081-123-4567</a>
                    <label class="font-grey font-light arial">081-123-4567</label>
                </td>
            </tr>
            <tr>
                <td class="center s-cell no-border"><i class="contact-btn location fas fa-map-marker-alt"></i></td>
                <td class="no-border"><a class="link-text font-bold arial" style="display: none;">ที่อยู่ของร้าน</a>
                    <label class="font-grey font-light arial">ที่อยู่ของร้าน</label>
                </td>
            </tr>
            <tr>
                <td class="center s-cell no-border"><i class="contact-btn line fab fa-line"></i></td>
                <td class="no-border"><a class="link-text font-bold arial" style="display: none;">Line ของคุณ</a>
                    <label class="font-grey font-light arial">Line ของคุณ</label>
                </td>
            </tr>
        </table>
      </div>
    </div>
    <div class="alert-box help">
      คุณสามารถสร้างตู้แสดงสินค้าได้ไม่จำกัดจำนวน และสามารถเลือกสินค้าจากในร้านมาใส่ได้ตามต้องการ<br>
      **ถ้าไม่ได้สร้างตู้ไว้ ระบบจะแสดงสินค้าที่มียอดเข้าชมสูงสุดของคุณแทน
    </div>
    <div class="panel-body" id="full-line">
      <label class="heading padding-15-bottom">ตู้แสดงสินค้า 1</label>
      <div class="shop-carousel">
        <div class="carousel-thumb-wrap">
          <a>
            <img src="https://s3-ap-southeast-1.amazonaws.com/images.closet.com/product/thumbnail/example/1.jpeg" alt="1">
          </a>
          <span class="thumb-price bottom-left">1,600฿</span>
        </div>
        <div class="carousel-thumb-wrap">
          <a>
            <img src="https://s3-ap-southeast-1.amazonaws.com/images.closet.com/product/thumbnail/example/2.jpeg" alt="1">
          </a>
          <span class="thumb-price bottom-left">990฿</span>
        </div>
        <div class="carousel-thumb-wrap">
          <a>
            <img src="https://s3-ap-southeast-1.amazonaws.com/images.closet.com/product/thumbnail/example/3.jpeg" alt="1">
          </a>
          <span class="thumb-price bottom-left">99฿</span>
        </div>
        <div class="carousel-thumb-wrap">
          <a>
            <img src="https://s3-ap-southeast-1.amazonaws.com/images.closet.com/product/thumbnail/example/4.jpeg" alt="1">
          </a>
          <span class="thumb-price bottom-left">500฿</span>
        </div>
        <div class="carousel-thumb-wrap">
          <a>
            <img src="https://s3-ap-southeast-1.amazonaws.com/images.closet.com/product/thumbnail/example/5.jpeg" alt="1">
          </a>
          <span class="thumb-price bottom-left">1,290฿</span>
        </div>
        <div class="carousel-thumb-wrap">
          <a>
            <img src="https://s3-ap-southeast-1.amazonaws.com/images.closet.com/product/thumbnail/example/6.jpeg" alt="1">
          </a>
          <span class="thumb-price bottom-left">350฿</span>
        </div>
      </div>
    </div>

    <div class="panel-body" id="full-line">
      <label class="heading padding-15-bottom">ตู้แสดงสินค้า 2 (ตัวอย่างสินค้าลดราคา)</label>
      <div class="shop-carousel">
        <div class="carousel-thumb-wrap">
          <a>
            <img src="https://s3-ap-southeast-1.amazonaws.com/images.closet.com/product/thumbnail/example/1.jpeg" alt="1">
          </a>
          <span class="sale top-right"></span>
          <span class="thumb-price-discount bottom-left">
            <s>1,600</s><br>
              1,200฿
          </span>
        </div>
        <div class="carousel-thumb-wrap">
          <a>
            <img src="https://s3-ap-southeast-1.amazonaws.com/images.closet.com/product/thumbnail/example/2.jpeg" alt="1">
          </a>
          <span class="sale top-right"></span>
          <span class="thumb-price-discount bottom-left">
            <s>990</s><br>
              550฿
          </span>
        </div>
        <div class="carousel-thumb-wrap">
          <a>
            <img src="https://s3-ap-southeast-1.amazonaws.com/images.closet.com/product/thumbnail/example/3.jpeg" alt="1">
          </a>
          <span class="sale top-right"></span>
          <span class="thumb-price-discount bottom-left">
            <s>99</s><br>
              98฿
          </span>
        </div>
        <div class="carousel-thumb-wrap">
          <a>
            <img src="https://s3-ap-southeast-1.amazonaws.com/images.closet.com/product/thumbnail/example/4.jpeg" alt="1">
          </a>
          <span class="sale top-right"></span>
          <span class="thumb-price-discount bottom-left">
            <s>500</s><br>
              469฿
          </span>
        </div>
        <div class="carousel-thumb-wrap">
          <a>
            <img src="https://s3-ap-southeast-1.amazonaws.com/images.closet.com/product/thumbnail/example/5.jpeg" alt="1">
          </a>
          <span class="sale top-right"></span>
          <span class="thumb-price-discount bottom-left">
            <s>1,290</s><br>
              1,100฿
          </span>
        </div>
        <div class="carousel-thumb-wrap">
          <a>
            <img src="https://s3-ap-southeast-1.amazonaws.com/images.closet.com/product/thumbnail/example/6.jpeg" alt="1">
          </a>
          <span class="sale top-right"></span>
          <span class="thumb-price-discount bottom-left">
            <s>350</s><br>
              329฿
          </span>
        </div>
      </div>
    </div>

  </div>
</div>
<script type="text/javascript">
  $('.shop-carousel').slick({
    infinite: false,
    speed: 300,
    slidesToShow: 5,
    slidesToScroll: 5,
    responsive: [
      {
        breakpoint: 992,
        settings: { slidesToShow: 4, slidesToScroll: 4, infinite: false}
      },
      {
        breakpoint: 600,
        settings: { slidesToShow: 3, slidesToScroll: 3 }
      },
      {
        breakpoint: 480,
        settings: { slidesToShow: 2, slidesToScroll: 2 }
      },
      {
        breakpoint: 350,
        settings: { slidesToShow: 1, slidesToScroll: 1 }
      }
    ]
  });
  $('.contact-btn').click(function () {
    $('.contacts').toggleClass('not-display')
  });
</script>
<style media="screen">
  img {
    width: 100%;
  }
</style>
@endsection
