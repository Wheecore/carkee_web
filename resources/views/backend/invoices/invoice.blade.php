<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>invoice</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
	<style media="all">
        @page {
			margin: 0;
			padding:0;
		}
		body{
			font-size: 0.875rem;
            font-family: '<?php echo  $font_family ?>';
            font-weight: normal;
            direction: <?php echo  $direction ?>;
            text-align: <?php echo  $text_align ?>;
			padding:0;
			margin:0; 
		}
		.gry-color *,
		.gry-color{
			color:#878f9c;
		}
		table{
			width: 100%;
		}
		table th{
			font-weight: normal;
		}
		table.padding th{
			padding: .25rem .7rem;
		}
		table.padding td{
			padding: .25rem .7rem;
		}
		table.sm-padding td{
			padding: .1rem .7rem;
		}
		.border-bottom td,
		.border-bottom th{
			border-bottom:1px solid #eceff4;
		}
		.text-left{
			text-align:<?php echo  $text_align ?>;
		}
		.text-right{
			text-align:<?php echo  $not_text_align ?>;
		}
	</style>
</head>
<body>
	<div>
		@php
		$logo = get_setting('header_logo');
		$shop = \App\Models\Shop::where('id', $order->seller_id)->first();
		@endphp
		<div style="background: #eceff4;padding: 1rem;">
			<table>
				<tr>
					<td>
						@if($logo != null)
							<img src="{{ uploaded_asset($logo) }}" height="30" style="display:inline-block;">
						@else
							<img src="{{ static_asset('assets/img/logo.png') }}" height="30" style="display:inline-block;">
						@endif
					</td>
					<td style="font-size: 1.5rem;" class="text-right strong">{{  translate('INVOICE') }}</td>
				</tr>
			</table>
			<table>
			
				<tr>
					<td class="gry-color small"><b>Triune Autotech Sdn. Bhd. (Co. No. 202001016227) </b>  </td>
				</tr>
				<tr>
					<td class="gry-color small">No.30, Jalan SS26/11  </td>
				</tr>
				<tr>
					<td class="gry-color small">Taman Mayang Jaya  </td>
				</tr>
				<tr>
					<td class="gry-color small">47301 Petaling Jaya  </td>
				</tr>
				<tr>
					<td class="gry-color small">Selangor Darul Ehsan  </td>
				</tr>
				<br><br>
				<tr>
					<td class="gry-color small">{{  translate('Email') }}: {{ get_setting('contact_email') }}</td>
					<td class="text-right small"><span class="gry-color small">{{  translate('Order ID') }}:</span> <span class="strong">{{ $order->code }}</span></td>
				</tr>
				<tr>
					<td class="gry-color small">{{  translate('Phone') }}: {{ get_setting('contact_phone') }}</td>
					<td class="text-right small"><span class="gry-color small">{{  translate('Order Date') }}:</span> <span class=" strong">{{ convert_datetime_to_local_timezone(date('Y-m-d h:i:s', $order->date), user_timezone(Auth::check()?Auth::id():$order->user_id)) }}</span></td>
				</tr>
				<tr>
					<td class="gry-color small">{{  translate('Workshop Name') }}: {{ ($shop) ? $shop->name : '-' }}</td>
					<td class="text-right small"><span class="gry-color small">{{  translate('Booking Date') }}:</span> <span class=" strong">{{ $order->workshop_date ? date(env('DATE_FORMAT'),strtotime($order->workshop_date)):'-' }}</span></td>
				</tr>
				<tr>
					<td class="gry-color small">{{  translate('Workshop Address') }}: {{ ($shop) ? $shop->address : '-' }}</td>
					<td class="text-right small"><span class="gry-color small">{{  translate('Booking Time') }}:</span> <span class=" strong">{{ $order->workshop_time }}</span></td>
				</tr>
				@if($order->user_date_update == 1)
				<tr>
					<td class="gry-color small"></td>
					<td class="text-right small"><span class="gry-color small">{{  translate('Old Booking Date') }}:</span> <span class="strong">{{ $order->old_workshop_date ? date(env('DATE_FORMAT'),strtotime($order->old_workshop_date)):'-' }}</span></td>
				</tr>
				<tr>
					<td class="gry-color small"></td>
					<td class="text-right small"><span class="gry-color small">{{  translate('Old Booking Time') }}:</span> <span class=" strong">{{ $order->old_workshop_time }}</span></td>
				</tr>
				@endif
				@if ($order->reassign_date)
				<tr>
					<td class="gry-color small"></td>
					<td class="text-right small"><span class="gry-color small">{{  translate('Reassign Date') }}:</span> <span class="strong">{{ convert_datetime_to_local_timezone($order->reassign_date, user_timezone(Auth::check()?Auth::id():$order->user_id)) }}</span></td>
				</tr>
			    @endif
			@if ($order->old_workshop_id)
			    @php
					$old_shop = \DB::table('shops')
						->where('id', $order->old_workshop_id)
						->select('name')
						->first();
					$old_shop_reassign_data = $order->reassign_data?json_decode($order->reassign_data, true):[];
					$old_shop_app_date = '';
					$old_shop_app_time = '';
					if(!empty($old_shop_reassign_data)){
						$old_shop_app_date = date(env('DATE_FORMAT'), strtotime($old_shop_reassign_data['old_workshop_date']));
						$old_shop_app_time = $old_shop_reassign_data['old_workshop_time'];
					}
				@endphp
				<tr>
					<td class="gry-color small"></td>
					<td class="text-right small"><span class="gry-color small">{{ translate('Old Workshop Name') }}:</span><span class="strong">{{ $old_shop && $old_shop->name ? $old_shop->name : '' }}</span></td>
				</tr>
				<tr>
					<td class="gry-color small"></td>
					<td class="text-right small"><span class="gry-color small">{{ translate('Old Workshop Booking Date') }}:</span><span class="strong">{{ $old_shop_app_date }}</span></td>
				</tr>
				<tr>
					<td class="gry-color small"></td>
					<td class="text-right small"><span class="gry-color small">{{ translate('Old Workshop Booking Time') }}:</span><span class="strong">{{ $old_shop_app_time }}</span></td>
				</tr>
			@endif
			</table>

		</div>

		<div style="padding: 1rem;padding-bottom: 0">
            <table>
				@php
					$user = \DB::table('users')->where('id',$order->user_id)->select('name')->first();
					$tyre_products = DB::table('order_details')
					->where('order_details.order_id', $order->id)
					->where('order_details.type', 'T')
					->leftJoin('products', 'products.id', '=', 'order_details.product_id')
					->leftJoin('product_translations', 'product_translations.product_id', '=', 'products.id')
					->select('product_translations.name', 'order_details.quantity', 'order_details.price','order_details.tax')
					->get();
					
                    $package_products = DB::table('order_details')
                     ->where('order_details.order_id', $order->id)
                    ->where('order_details.type', 'P')
                    ->leftJoin('products', 'products.id', '=', 'order_details.product_id')
                    ->leftJoin('product_translations', 'product_translations.product_id', '=', 'products.id')
                    ->select('product_translations.name', 'order_details.quantity', 'order_details.price', 'order_details.tax')
                    ->get();
				@endphp
				<tr><td class="strong small gry-color">{{ translate('Bill to') }}:</td></tr>
				<tr><td class="strong">{{ $user->name }}</td></tr>
				<tr><td class="strong">{{ $order->model_name }}</td></tr>
				<tr><td class="strong">{{ $order->car_plate }}</td></tr>
{{--				<tr><td class="gry-color small">{{ $shipping_address->address }}, {{ $shipping_address->city }}, {{ $shipping_address->country }}</td></tr>--}}
				{{--<tr><td class="gry-color small">{{ translate('Email') }}: {{ $shipping_address->email }}</td></tr>--}}
				{{--<tr><td class="gry-color small">{{ translate('Phone') }}: {{ $shipping_address->phone }}</td></tr>--}}
			</table>
		</div>

	    <div style="padding: 1rem;">
	        @if(count($tyre_products) > 0)
	        <div style="padding-top: 1rem;padding-bottom: .7rem">
            <table>
				<tr><td class="strong">Tyre Products</td></tr>
			</table>
		  </div> 
			<table class="padding text-left small border-bottom">
				<thead>
	                <tr class="gry-color" style="background: #eceff4;">
	                    <th width="35%" class="text-left">{{ translate('Product Name') }}</th>
	                    <th width="10%" class="text-left">{{ translate('Qty') }}</th>
	                    <th width="15%" class="text-left">{{ translate('Unit Price') }}</th>
	                    <th width="15%" class="text-left">{{ translate('Total') }}</th>
	                </tr>
				</thead>
				<tbody class="strong">
	                @foreach ($tyre_products as $key => $orderDetail)
							<tr>
    							@php $product_name_with_choice = ($orderDetail->name != null) ? $orderDetail->name : translate('Product Unavailable');
                                @endphp
								<td>{{ $product_name_with_choice }}</td>
								<td>{{ $orderDetail->quantity }}</td>
								<td class="currency">{{ single_price($orderDetail->price/$orderDetail->quantity) }}</td>
			                    <td class="currency">{{ single_price($orderDetail->price+$orderDetail->tax) }}</td>
							</tr>
					@endforeach
	            </tbody>
			</table>
			@endif
			
			@if(count($package_products) > 0)
			<div style="padding-top: 1rem;padding-bottom: .7rem">
            <table>
				<tr><td class="strong">Package Products</td></tr>
			</table>
		  </div>
			<table class="padding text-left small border-bottom">
				<thead>
	                <tr class="gry-color" style="background: #eceff4;">
	                    <th width="35%" class="text-left">{{ translate('Product Name') }}</th>
	                    <th width="10%" class="text-left">{{ translate('Qty') }}</th>
	                    <th width="15%" class="text-left">{{ translate('Unit Price') }}</th>
	                    <th width="15%" class="text-left">{{ translate('Total') }}</th>
	                    <th width="15%" class="text-left">{{ translate('Package Name') }}</th>
	                </tr>
				</thead>
				<tbody class="strong">
	                @foreach ($package_products as $key => $orderDetail)
							<tr>
								<td>{{ $orderDetail->name != null ? $orderDetail->name: translate('Product Unavailable')}}</td>
								<td>{{ $orderDetail->quantity }}</td>
								<td class="currency">{{ single_price($orderDetail->price/$orderDetail->quantity) }}</td>
			                    <td class="text-right currency">{{ single_price($orderDetail->price+$orderDetail->tax) }}</td>
			                    <td>{{ translate('Package') }}</td>
							</tr>
					@endforeach
	            </tbody>
			</table>
			@endif
			
			@if($order->is_gift_product_availed)
			<div style="padding-top: 1rem;padding-bottom: .7rem">
            <table>
				<tr><td class="strong">Discount Gift</td></tr>
			</table>
		   </div>
			<table class="padding text-left small border-bottom">
				<thead>
	                <tr class="gry-color" style="background: #eceff4;">
	                    <th width="35%" class="text-left">{{ translate('Discount Title') }}</th>
	                    <th width="10%" class="text-left">{{ translate('Gift Name') }}</th>
	                    <th width="15%" class="text-left">{{ translate('Gift Image') }}</th>
	                </tr>
				</thead>
				<tbody class="strong">
	                @php $gift_datas = json_decode($order->gift_product_data); @endphp
							<tr class="">
								<td>{{ $gift_datas->discount_title }}</td>
								<td class="">{{ $gift_datas->gift_name }}</td>
								<td class="currency"><img src="{{ uploaded_asset($gift_datas->gift_image) }}" alt="" height="50"></td>
							</tr>
	            </tbody>
			</table>
            @endif
		</div>

	    <div style="padding:0 1.5rem;">
	        <table class="text-right sm-padding small strong">
	        	<thead>
	        		<tr>
	        			<th width="60%"></th>
	        			<th width="40%"></th>
	        		</tr>
	        	</thead>
		        <tbody>
			        <tr>
			            <td>
			            </td>
			            <td>
					        <table class="text-right sm-padding small strong">
						        <tbody>
									@php 
									$class_result = false;
									$exp_class = false;
									$discount_class = false;
										 if($order->express_delivery){
											$exp_class = true;
											$class_result = true;
										 }
										 else if($order->is_gift_discount_applied){
											$discount_class = true;
											$class_result = true;
										 }
									 @endphp
							        <tr>
							            <th class="gry-color text-left">{{ translate('Sub Total') }}</th>
							            <td class="currency">{{ single_price($order->orderDetails->sum('price')) }}</td>
							        </tr>
				                    <tr class="{{ !$class_result?'border-bottom':'' }}">
							            <th class="gry-color text-left">{{ translate('Coupon Discount') }}</th>
							            <td class="currency">{{ single_price($order->coupon_discount) }}</td>
							        </tr>
									@if($order->is_gift_discount_applied)
									@php $gift_discount_data = json_decode($order->gift_discount_data); @endphp
									<tr class="{{ ($discount_class && !$exp_class)?'border-bottom':'' }}">
							            <th class="gry-color text-left">{{ translate('Gift Discount') }} ({{ $gift_discount_data->title }})</th>
							            <td class="currency">{{ single_price($gift_discount_data->discount) }}</td>
							        </tr>
									@endif
							        @if($order->express_delivery)
							        <tr class="{{ ($exp_class && !$discount_class)?'border-bottom':'' }}">
							            <th class="gry-color text-left">{{ translate('Express Delivery') }}</th>
							            <td class="currency">{{ single_price($order->express_delivery) }}</td>
							        </tr>
							        @endif
							        <tr>
							            <th class="text-left strong">{{ translate('Grand Total') }}</th>
							            <td class="currency">{{ single_price($order->grand_total) }}</td>
							        </tr>
						        </tbody>
						    </table>
			            </td>
			        </tr>
		        </tbody>
		    </table>
	    </div>

	</div>
</body>
</html>
