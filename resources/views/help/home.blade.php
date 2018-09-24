@extends('help.layout')

@section('script')
<script>
$(document).ready(function(){
    $("#hide").click(function(){
        $("p").hide();
    });
    $("#show").click(function(){
        $("#list").toggle();
    });
});
</script>
@endsection

@section('content')
<div class="panel-body">
  <h2>ศูนย์ช่วยเหลือ</h2>
  <h2><a href="{{ route('sellerGuide') }}">สำหรับผู้ขาย&nbsp;<i class="fas fa-chevron-right"></i></a></h2>
  <div id="full-line">
    <ul class="list-no-style">
      <li class="font-15em">เริ่มต้นขาย</li>
      <ul>
        <li>การลงขายสินค้า</li>
        <li>แก้ไขสินค้าหรือเพิ่มตัวเลือก</li>
        <li>จัดโปรโมชั่น</li>
        <li>สิ่งที่ต้องทำเมื่อลูกค้าซื้อสินค้าและการปฏิเสธการสั่งซื้อ</li>
        <li>หากลูกค้าไม่ได้ชำระเงินนานเกินกำหนด</li>
      </ul>
      <li class="font-15em">ตกแต่งและจัดการร้านของคุณ</li>
      <ul>
        <li>การแก้ไขข้อมูลโปรไฟล์</li>
        <li>เพิ่มช่องทางติดต่อและ Social network</li>
        <li>ตู้แสดงสินค้า</li>
        <li>คอลเล็คชั่น</li>
        <li>บัญชีธนาคาร</li>
      </ul>
    </ul>
  </div>
  <h2><a href="{{ route('buyerGuide') }}">สำหรับผู้ซื้อ&nbsp;<i class="fas fa-chevron-right"></i></a></h2>
  <div id="full-line">
    <ul class="list-no-style">
      <li class="font-15em">การสั่งซื้อสินค้า</li>
      <ul>
        <li>การเลือกสินค้า</li>
        <li>ยืนยันการสั่งซื้อและการใช้โค๊ดโปรโมชั่น</li>
        <li>การชำระเงิน</li>
        <li>รีวิวผู้ขาย</li>
        <li>การยกเลิกรายการสั่งซื้อ</li>
      </ul>
      <li class="font-15em">การแจ้งปัญหา</li>
      <ul>
        <li>แจ้งปัญหาสินค้าหรือผู้ขาย</li>
      </ul>
    </ul>
  </div>
  <h2>สอบถามปัญหาอื่นๆ</h2>
  <div id="full-line">
    <ul>
      <a class="font-large" href="{{ route('askPage') }}">คลิกที่นี่เพื่อสอบถามปัญหา&nbsp;<i class="fas fa-chevron-right"></i></a>
    </ul>

  </div>
</div>

@endsection
