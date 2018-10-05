@extends('help.layout')

@section('content')
<div class="panel-heading">
<a class="font-large" href="{{ route('helpHome') }}"><< กลับหน้าแรก</a>
</div>
<div class="padding-10">
<label class="heading">คำแนะนำสำหรับผู้ขาย</label>
</div>
<div class="padding-10">
<label class="heading font-orange"># เริ่มต้นขาย</label>
</div>
<div class="full-width" id="full-line">
  <button class="flat-btn align-left padding-10" id="1">การลงขายสินค้า&nbsp;<small class="fas fa-chevron-down"></small></button>
  <div class="panel padding-15-bottom" id="panel1">
    <ul class="no-margin" style="list-style-type: decimal">
      <i class="font-red">*คุณต้องทำการสมัครสมาชิกและล็อกอินก่อนที่จะขายสินค้า</i>
      <li>ไปที่เมนู <i class="fas fa-bars"></i> หรือ <i class="fas fa-user"></i> คลิกที่ <strong>ขาย</strong> และเลือกว่าจะขายสินค้าใหม่หรือมือสอง</li>
      <li>คุณจะพบแบบฟอร์มในการลงขายสินค้า</li>
      <li>กรอกข้อมูลให้ครบทุกช่อง รวมถึงเลือกรูปสินค้า</li>
      <li>เลือกหมวดหมู่สินค้าให้ถูกต้อง เพื่อที่ผู้ซื้อจะได้ค้นหาสินค้าของคุณได้อย่างถูกต้อง<br><i class="font-red">*หากไม่แน่ใจว่าควรเลือกหมวดหมู่ไหนให้เลือกที่คุณคิดว่าใกล้เคียงที่สุด</i></li>
      <li>คลิก <strong>ลงขาย</strong> จากนั้นรอให้ระบบอัพโหลดสินค้าของคุณซักพักคุณจะเข้าสู่หน้าคำแนะนำที่ต้องทำต่อไป</li>
    </ul>
  </div>
</div>
<div class="full-width" id="full-line">
  <button class="flat-btn align-left padding-10" id="2">แก้ไขสินค้าหรือเพิ่มตัวเลือก&nbsp;<small class="fas fa-chevron-down"></small></button>
  <div class="panel padding-15-bottom" id="panel2">
    <ul class="no-margin" style="list-style-type: decimal">
      <li>ไปที่เมนู <i class="fas fa-bars"></i> หรือ <i class="fas fa-user"></i> คลิกที่ <strong>สินค้าของฉัน</strong> เลือกสินค้าใหม่หรือมือสอง</li>
      <li>หากต้องการแก้ไขสินค้าเลือก <i class="fas fa-pen"></i> หากต้องการลบเลือก <i class="fas fa-trash-alt"></i></li>
      <li>เมื่อเลือก <i class="fas fa-pen"></i> คุณก็จะเข้าสู่หน้าการแก้ไขสินค้า</li>
      <li>
        ในแถบ <strong>แก้ไขสินค้า</strong> คุณสามารถแก้ไข<br>
        - รูปขนาดย่อ ขนาดไม่เกิน 1MB<br>
        - รายละเอียดของสินค้า<br>
      </li>
      <li>
        ในแถบ <strong>อัพโหลดรูปภาพ</strong> คุณสามารถ<u>ลบ</u> หรือ<u>อัพโหลด</u>รูปภาพเพิ่มเติมได้<br>
        <i class="font-red">*การอัพโหลดรูปภาพอาจใช้เวลาซักพัก เมื่ออัพโหลดเสร็จแล้วรูปภาพอาจยังไม่แสดงผลในทันที</i>
      </li>
      <li>
        ในแถบ <strong>ตัวเลือกสินค้า</strong> คุณสามารถเพิ่ม หรือลบ ตัวเลือกของสินค้าได้<br>
        - การเพิ่มตัวเลือก ให้กรอกตัวเลือกที่ต้องการ แล้วคลิก <i class="fas fa-check-square"></i><br>
        - คุณสามารถเลือกให้แสดงเฉพาะตัวเลือกที่คุณต้องการได้โดยการคลิกที่ <i class="fas fa-check-square"></i> หรือ <i class="far fa-square"></i><br>
        <i class="fas fa-check-square"></i> คือ <u>แสดงอยู่</u> <i class="far fa-square"></i> คือ <u>ถูกซ่อนอยู่</u>
      </li>
    </ul>
  </div>
</div>
<div class="full-width" id="full-line">
  <button class="flat-btn align-left padding-10" id="3">จัดโปรโมชั่น&nbsp;<small class="fas fa-chevron-down"></small></button>
  <div class="panel padding-15-bottom" id="panel3">
    <ul class="no-margin" style="list-style-type: decimal">
      <li>ไปที่เมนู <i class="fas fa-bars"></i> คลิกที่ <i class="fas fa-tag"></i>&nbsp;<strong>จัดการโปรโมชั่น</strong></li>
      <li>เลือกโปรโมชั่นที่คุณต้องการจัด</li>
      <i class="font-red">*โปรดอ่านรายละเอียดก่อนเลือก</i><br>
    </ul>
  </div>
</div>
<div class="full-width" id="full-line">
  <button class="flat-btn align-left padding-10" id="4">สิ่งที่ต้องทำเมื่อลูกค้าซื้อสินค้าและการปฏิเสธการสั่งซื้อ&nbsp;<small class="fas fa-chevron-down"></small></button>
  <div class="panel padding-15-bottom" id="panel4">
    <ul class="no-margin" style="list-style-type: decimal">
      <li>เมื่อลูกค้าสั่งซื้อสินค้า <u>คุณจะได้รับรายการสินค้าที่ลูกค้าสั่ง ผ่านทางอีเมลของคุณ</u></li>
      <i class="font-red">*คุณสามาถปฏิเสธรายการสั่งซื้อได้ก่อนที่จะได้รับการชำระเงินเท่านั้น</i>
      <li>
        หากต้องการปฏิเสธรายการสั่งซื้อ คุณสามารถทำได้ผ่านลิงค์ทางอีเมลของคุณ<br>
        หรือผ่านทางเว็บไซต์ โดยไปที่เมนู <i class="fas fa-bars"></i> และไปที่ <strong>รายการขาย</strong><br>
        เมื่อคุณทำการปฏิเสธรายการแล้ว ผู้ซื้อจะได้รับอีเมลแจ้งโดยอัตโนมัติ
      </li>
      <li>เมื่อลูกค้าทำการชำระเงิน (โอนเงิน) <strong>คุณจะได้รับอีเมลแจ้งวันและเวลาที่ชำระ</strong> หรือ คุณสามารถดูผ่านเว็บไซต์ได้ใน <i class="fas fa-list-ul"></i>&nbsp;<strong>รายการขาย</strong></li>
      <li>หลังจากทำการส่งสินค้าแล้ว <u>คุณต้องทำการแจ้งให้ลูกค้าทราบถึงการจัดส่ง</u> <strong>โดยใช้ลิงค์จากอีเมลแจ้งชำระเงิน</strong> หรือ คุณสามารถทำผ่านเว็บไซต์ได้ใน <i class="fas fa-list-ul"></i>&nbsp;<strong>รายการขาย</strong></li>
      <li>เมื่อทำการแจ้งลูกค้าแล้วก็ถือว่าเป็นการเสร็จสิ้น ลูกค้าจะให้คะแนนร้านค้าของคุณ หากไม่ได้ให้คะแนนร้านค้าของคุณ คุณอาจทำการแจ้งพวกเขาเป็นการส่วนตัวก็ได้</li>
    </ul>
  </div>
</div>
<div class="full-width" id="full-line">
  <button class="flat-btn align-left padding-10" id="5">หากลูกค้าไม่ได้ชำระเงินนานเกินกำหนด&nbsp;<small class="fas fa-chevron-down"></small></button>
  <div class="panel padding-15-bottom" id="panel5">
    <ul class="no-margin">
      รายการสั่งซื้อที่ไม่ได้แจ้งชำระเงินภายใน 3 วัน จะถูกลบออกจากระบบโดยอัตโนมัติ<br>
      <i>*รายการที่ถูกลบแล้วยังสามารถเรียกดูได้ผ่านทางประวัติรายการขาย</i>
    </ul>
  </div>
</div>
<div class="padding-10">
<label class="heading font-orange"># ตกแต่งและจัดการร้านของคุณ</label>
</div>
<div class="full-width" id="full-line">
  <button class="flat-btn align-left padding-10" id="6">การแก้ไขข้อมูลโปรไฟล์&nbsp;<small class="fas fa-chevron-down"></small></button>
  <div class="panel padding-15-bottom" id="panel6">
    <ul class="no-margin" style="list-style-type: decimal">
      <li>ไปที่เมนู <i class="fas fa-bars"></i> หรือ <i class="fas fa-user"></i> คลิกที่ <strong>ตั้งค่าโปรไฟล์</strong></li>
      <li>คุณก็จะเข้าสู่หน้าการตั้งค่าโปรไฟล์</li>
      <li>
        ในแถบ <strong>ทั่วไป</strong> คุณสามารถแก้ไข<br>
        - รูปขนาดย่อ ขนาดไม่เกิน 1MB<br>
        - รูปภาพหน้าปก ขนาดไม่เกิน 1MB<br>
        - ข้อมูลโปรไฟล์ และข้อมูลที่อยู่ในการจัดส่ง<br>
      </li>
    </ul>
  </div>
</div>
<div class="full-width" id="full-line">
  <button class="flat-btn align-left padding-10" id="7">เพิ่มช่องทางติดต่อและ Social network&nbsp;<small class="fas fa-chevron-down"></small></button>
  <div class="panel padding-15-bottom" id="panel7">
    <ul class="no-margin" style="list-style-type: decimal">
      <li>ไปที่เมนู <i class="fas fa-bars"></i> คลิกที่ <strong>จัดการหลังร้าน</strong></li>
      <li>คุณก็จะเข้าสู่หน้าการตั้งค่าจัดการหลังร้าน</li>
      <li>
        ในแถบ <strong>ติดต่อ</strong> คุณสามารถเพิ่มหรือแก้ไขช่องทางการติดต่อของคุณได้<br>
        เมื่อคุณทำการเพิ่มแล้ว ช่องทางติดต่อของคุณก็จะ<u>แสดงอยู่บนหน้าร้าน</u>และ<u>หน้าแสดงสินค้าของคุณ</u>
      </li>
    </ul>
  </div>
</div>
<div class="full-width" id="full-line">
  <button class="flat-btn align-left padding-10" id="8">ตู้แสดงสินค้า&nbsp;<small class="fas fa-chevron-down"></small></button>
  <div class="panel padding-15-bottom" id="panel8">
    <p class="padding-15-horizontal"><strong>ตู้แสดงสินค้า</strong>&nbsp;เป็นเครื่องมือสำคัญที่จะทำให้คุณสามารถแสดงสินค้าที่ต้องการได้บนหน้าร้านของคุณ</p>
    <ul class="no-margin" style="list-style-type: decimal">
      <li>ไปที่เมนู <i class="fas fa-bars"></i> คลิกที่ <strong>จัดการหลังร้าน</strong></li>
      <li>คุณก็จะเข้าสู่หน้าการตั้งค่าจัดการหลังร้าน</li>
      <li>
        ในแถบ <strong>ตู้แสดงสินค้า</strong> คุณสามารถเพิ่มหรือแก้ไขตู้แสดงสินค้าได้<br>
        หากต้องการแก้ไขสินค้าเลือก <i class="fas fa-pen"></i> หากต้องการลบเลือก <i class="fas fa-trash-alt"></i>
      </li>
      <li>หากคุณต้องการเพิ่มสินค้าในร้านเข้าไปในตู้ คุณสามารถทำได้โดยเข้าไปแก้ไข <i class="fas fa-pen"></i></li>
    </ul>
  </div>
</div>
<div class="full-width" id="full-line">
  <button class="flat-btn align-left padding-10" id="9">คอลเล็คชั่น&nbsp;<small class="fas fa-chevron-down"></small></button>
  <div class="panel padding-15-bottom" id="panel9">
    <p class="padding-15-horizontal"><strong>คอลเล็คชั่น</strong>&nbsp;เป็นเครื่องมือที่ทำให้คุณสามารถนำเสนอรูปภาพ พร้อมกับอ้างอิงสินค้าลงไปในคอลเล็คชั่นได้ ทำให้คุณสามารถแสดงสินค้าได้หลายชิ้นพร้อมรูปตัวอย่างภายในคราวเดียว</p>
    <ul class="no-margin" style="list-style-type: decimal">
      <li>ไปที่เมนู <i class="fas fa-bars"></i> คลิกที่ <strong>จัดการหลังร้าน</strong></li>
      <li>คุณก็จะเข้าสู่หน้าการตั้งค่าจัดการหลังร้าน</li>
      <li>
        ในแถบ <strong>ตู้แสดงสินค้า</strong> คุณสามารถเพิ่มหรือแก้ไขตู้แสดงสินค้าได้<br>
        หากต้องการแก้ไขสินค้าเลือก <i class="fas fa-pen"></i> หากต้องการลบเลือก <i class="fas fa-trash-alt"></i>
      </li>
      <li>หากคุณต้องการเพิ่มสินค้าในร้านเข้าไปในตู้ คุณสามารถทำได้โดยเข้าไปแก้ไข <i class="fas fa-pen"></i></li>
    </ul>
  </div>
</div>
<div class="full-width" id="full-line">
  <button class="flat-btn align-left padding-10" id="10">บัญชีธนาคาร&nbsp;<small class="fas fa-chevron-down"></small></button>
  <div class="panel padding-15-bottom" id="panel10">
    <p class="padding-15-horizontal"><strong>บัญชีธนาคาร</strong>&nbsp;จะแสดงในรายการสั่งซื้อของผู้ซื้อเมื่อสั่งสินค้าเพื่อชำระเงิน</p>
    <ul class="no-margin" style="list-style-type: decimal">
      <li>ไปที่เมนู <i class="fas fa-bars"></i> คลิกที่ <strong>จัดการหลังร้าน</strong></li>
      <li>คุณก็จะเข้าสู่หน้าการตั้งค่าจัดการหลังร้าน</li>
      <li>
        ในแถบ <strong>บัญชีธนาคาร</strong> คุณสามารถเพิ่มหรือลบบัญชีธนาคารได้<br>
      </li>
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
      $('#' + this.id + ' > small').toggleClass('fa-chevron-down fa-chevron-down font-orange');
    });
});
</script>
@endsection
