<div class="tab-nav">
    <ul class="tab-nav-ul static">
        <button class="tab-nav-btn {{$current == 'home' ? 'current' : ''}}" onclick="document.location.href='{{ route('homeExample') }}'"><i class="fas fa-home"></i><font>หน้าแรก</font></button>
        <button class="tab-nav-btn {{$current == 'product' ? 'current' : ''}}" onclick="document.location.href='{{ route('productExample') }}'"><i class="fas fa-shopping-bag"></i><font>สินค้า</font></button>
        <button class="tab-nav-btn {{$current == 'collection' ? 'current' : ''}}" onclick="document.location.href='{{ route('colExample') }}'"><i class="fas fa-map"></i><font>คอลเล็คชั่น</font></button>
        <button class="tab-nav-btn {{$current == 'about' ? 'current' : ''}}" onclick="document.location.href='{{ route('aboutExample') }}'"><i class="fas fa-user"></i><font>เกี่ยวกับ</font></button>
        <button class="tab-nav-btn {{$current == 'review' ? 'current' : ''}}" onclick="document.location.href='{{ route('reviewExample') }}'"><i class="fas fa-star"></i><font>รีวิว</font></button>
    </ul>
</div>
