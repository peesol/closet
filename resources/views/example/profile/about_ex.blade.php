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
    @include('example.profile._shopnav', ['current' => 'about'])
    <div class="panel-heading-alt">
      <label class="heading">เกี่ยวกับ</label>
    </div>
    <div class="panel-body-alt">
    <label class="heading">คำอธิบาย</label>
    <div class="about-description">
        <p>คำอธิบายร้านของคุณอยู่ที่นี่</p>
    </div>
    <label class="heading full-label">ช่องทางติดต่อ</label>
    <div>
        <table class="c-table">
            <tr>
                <td class="center s-cell no-border"><i class="contact-btn facebook fab fa-facebook"></i></td>
                <td class="no-border"><a href="https://closet.plus/register" class="link-text font-bold arial">Facebook</a>
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
  </div>
</div>
</div>
@endsection
