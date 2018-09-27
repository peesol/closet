@extends('help.layout')

@section('content')
<div class="panel-heading">
<a class="font-large" href="{{ route('helpHome') }}"><< กลับหน้าแรก</a>
</div>
<div class="padding-10">
<label class="heading">คำแนะนำสำหรับผู้ซื้อ</label>
</div>
<div class="padding-10">
<label class="heading font-orange"># การสั่งซื้อสินค้า</label>
</div>
<div class="full-width" id="full-line">
  <button class="flat-btn align-left padding-10" id="1">คำแนะนำในการเลือกสินค้า&nbsp;<i class="fas fa-chevron-down"></i></button>
  <div class="panel padding-15-bottom" id="panel1">
    <ul class="no-margin" style="list-style-type: decimal">
      <li>ควรตรวจสอบโปรไฟล์ผู้ขายก่อน (คะแนนร้านค้า ช่องทางติดต่อ ความน่าเชื่อถือ)</li>
      <li>ควรเลือกซื้อจากร้านค้าที่ได้รับการยืนยันแล้ว บนรูปสินค้าและชื่อโปรไฟล์จะมี&nbsp;<i class="fas fa-check verified-profile"></i> </li>
      <li>ไม่ควรเลือกสินค้าที่มีราคาถูกกว่าท้องตลาดจนเกินจริง</li>
    </ul>
  </div>
</div>
<div class="full-width" id="full-line">
  <button class="flat-btn align-left padding-10" id="2">การสั่งซื้อสินค้า&nbsp;<i class="fas fa-chevron-down"></i></button>
  <div class="panel padding-15-bottom" id="panel2">
    <ul class="no-margin" style="list-style-type: decimal">
      <li>เลือกสินค้าที่ต้องการ</li>
      <li>เลือกตัวเลือกสินค้า</li>
      <i class="font-link">*สินค้าบางรายการอาจไม่มีตัวเลือกสินค้าให้เลือก ทั้งนี้ขึ้นอยู่กับทางผู้ขาย</i>
      <li>เมื่อมั่นใจว่าจะต้องการซื้อแล้ว ให้คลิกหลยิบใส่ตะกร้า</li>
      <li>ถ้าหากต้องการยืนยันการสั่งซื้อให้ไปที่ รถเข็น <i class="fas fa-shopping-cart"></i></li>
    </ul>
  </div>
</div>
<div class="full-width" id="full-line">
  <button class="flat-btn align-left padding-10" id="3">ยืนยันการสั่งซื้อและการใช้โค๊ดโปรโมชั่น&nbsp;<i class="fas fa-chevron-down"></i></button>
  <div class="panel padding-15-bottom" id="panel3">
    <ul class="no-margin" style="list-style-type: decimal">
      <i class="font-red">**การชำระเงินเป็นแบบแยกตามร้าน มิใช่การชำระทีเดียวทั้งหมด</i>
      <li>ไปที่ รถเข็น <i class="fas fa-shopping-cart"></i></li>
      <li>เมื่อเข้ามาที่หน้ารถเข็นแล้ว ให้เลือกร้านที่คุณต้องการชำระเงิน</li>
      <li>เมื่อมั่นใจว่าจะต้องการซื้อแล้วให้คลิก <strong>ยืนยันการสั่งซื้อ</strong></li>
      <li>ให้เลือกช่องทางการจัดส่ง และตรวจสอบที่อยู่ให้เรียบร้อย</li>
      <li>หากมีโค๊ดส่วนลด คุณสามารถใช้ได้โดยคลิกที่ <strong>ใช้โค๊ดส่วนลด</strong></li>
      <li>เมื่อตรวจสอบรายละเอียดและใช้ส่วนลดเรียบร้อยแล้วให้คลิก <strong>สั่งซื้อ</strong></li>
      <li><strong>เช็คอีเมลของคุณ</strong> ในอีเมลนั้นจะมีรายการสั่งซื้อสินค้าพร้อมกับช่องทางชำระเงินระบุอยู่</li>
    </ul>
  </div>
</div>
<div class="full-width" id="full-line">
  <button class="flat-btn align-left padding-10" id="4">การชำระเงิน&nbsp;<i class="fas fa-chevron-down"></i></button>
  <div class="panel padding-15-bottom" id="panel4">
    <ul class="no-margin" style="list-style-type: decimal">
      <li><strong>เช็คอีเมลของคุณ</strong> เพื่อหารายการสั่งซื้อสินค้า</li>
      <li>ในอีเมลนั้นจะมีรายการสั่งซื้อสินค้าพร้อมกับช่องทางชำระเงินระบุอยู่</li>
      <li>เมื่อคุณเลือกช่องทางชำระเงินแล้ว ให้ชำระตามช่องทางที่คุณเลือก</li>
      <li>ให้แจ้งผู้ขายว่าคุณได้ทำการชำระเงินแล้ว <u>ผ่านทางลิงค์ในอีเมลของคุณ</u> หรือ <u>แจ้งผ่านทางเว็บไซต์</u>โดยไปที่ <i class="fas fa-bars"></i> และ <strong>รายการสั่งซื้อ</strong> <i class="fas fa-list-ul"></i></li>
      <i class="font-red">**การจ่ายเงินให้ร้านค้าที่มิใช่ร้านค้าซึ่งได้รับการยืนยันแล้ว <i class="fas fa-check verified-profile"></i> หากเกิดความเสียหายหรือผิดพลาดประการใด Closet จะไม่มีการชดใช้หรือรับผิดใดๆทั้งสิ้น</i>
      <li>เมื่อคุณแจ้งชำระเงินแล้ว ทางผู้ขายจะทำการตรวจสอบและส่งสินค้า <u>เมื่อสินค้าถูกส่งแล้วจะมีอีเมลส่งมาถึงคุณพร้อมรายละเอียดการจัดส่ง</u></li>
    </ul>
  </div>
</div>
<div class="full-width" id="full-line">
  <button class="flat-btn align-left padding-10" id="5">รีวิวร้านค้า&nbsp;<i class="fas fa-chevron-down"></i></button>
  <div class="panel padding-15-bottom" id="panel5">
    <ul class="no-margin" style="list-style-type: decimal">
      <p><strong>การให้คะแนนร้านค้า</strong>&nbsp;นั้นสามารถช่วยให้ร้านค้าได้รับความน่าเชื่อถือได้และคุณยังช่วยให้ผู้ซื้อคนอื่นตัดสินใจได้ง่ายขึ้นอีกด้วย</p>
      <li><strong>เช็คอีเมลของคุณ</strong> เพื่อหารายการสั่งซื้อสินค้าที่ถูกส่งแล้ว</li>
      <li>คุณสามารถให้คะแนนร้านค้ารวมถึงความคิดเห็นได้ผ่านลิงค์ภายในอีเมล</li>
    </ul>
  </div>
</div>
<div class="full-width" id="full-line">
  <button class="flat-btn align-left padding-10" id="5">การยกเลิกการสั่งซื้อ&nbsp;<i class="fas fa-chevron-down"></i></button>
  <div class="panel padding-15-bottom" id="panel5">
    <ul class="no-margin" style="list-style-type: decimal">
      <i class="font-red">**การยกเลิกรายการสั่งซื้อนั้นทำได้เฉพาะตอนยังไม่ชำระเงินเท่านั้น</i>
      <li>
        หากต้องการยกเลิกการสั่งซื้อ คุณสามารถทำได้ผ่านทางเว็บไซต์ โดยไปที่เมนู <i class="fas fa-bars"></i> และไปที่ <strong>รายการสั่งซื้อ</strong> หารายการที่ต้องการและคลิก <strong>ยกเลิกรายการสั่งซื้อนี้</strong>
      </li>
    </ul>
  </div>
</div>
<div class="padding-10">
<label class="heading font-orange"># การแจ้งปัญหา</label>
</div>
<div class="full-width" id="full-line">
  <button class="flat-btn align-left padding-10" id="6">แจ้งปัญหาสินค้าหรือผู้ขาย&nbsp;<i class="fas fa-chevron-down"></i></button>
  <div class="panel padding-15-bottom" id="panel6">
    <ul class="no-margin" style="list-style-type: decimal">
      <li><strong>แจ้งปัญหาผู้ขาย</strong>&nbsp; สามารถทำได้โดยเข้าไปที่หน้าโปรไฟล์ข้องผู้ขาย และคลิกที่ <strong>แจ้งปัญหาผู้ขาย</strong> ซึ่งอยู่ด้านมุมขวาบน</li>
      <li><strong>แจ้งปัญหาสินค้า</strong>&nbsp; สามารถทำได้โดยเข้าไปที่หน้าแสดงสินค้า ด้านล่างของชื่อผู้ขาย ให้คลิก <i class="fas fa-ellipsis-v"></i> และ <strong>แจ้งปัญหา</strong></li>
    </ul>
  </div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function(){
  $("div.panel").hide();
    $("button").click(function(){
      $('#panel' + this.id).toggle();
      $('#' + this.id + ' > i').toggleClass('fa-chevron-down fa-chevron-up font-orange');
    });
});
</script>
@endsection
