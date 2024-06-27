<h1>Xin chào bạn,</h1>
<p>Nhầm phục vụ khách hàng có trải nghiệm tốt hơn</p>
<p>Chúng tôi xin gửi mã giảm giá cho bạn với ưu đãi lên đến {{$discount}} % khi áp dụng mã này vào lần thanh toán tới:</p>
<p><strong>{{ $code }}</strong></p>
<p>Nhanh chân lên số lượng có hạn và mã sẽ hết hạn vào ngày  {{ date('d-m-Y', strtotime($expired_at)) }}</div>.</p>
