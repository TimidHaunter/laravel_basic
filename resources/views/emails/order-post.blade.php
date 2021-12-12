<p>尊敬的{{ $order->user->name }}</p>
<p>您单号为：{{ $order->order_no }} 的订单已经发货。</p>
<p>快递为：{{ $order->express_type }} ，快递单号为 ：{{ $order->express_no }}。</p>
<p>发货时间为：{{ $order->updated_at }}。</p>

<ul>
    @foreach($order->orderDetails()->with('goods')->get() as $details)
        <li>{{ $details->goods->title }}，单价为：{{ $details->price }}，数量为：{{ $details->num }}。</li>
    @endforeach
</ul>

<h5>总付款：{{ $order->amount }}</h5>
