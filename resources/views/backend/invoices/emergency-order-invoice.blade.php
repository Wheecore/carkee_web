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
					<td class="text-right small"><span class="gry-color small">{{  translate('Order ID') }}:</span>
					<span class="strong">{{ $order->code }}</span></td>
				</tr>
				<tr>
					<td class="gry-color small">{{  translate('Phone') }}: {{ get_setting('contact_phone') }}</td>
					<td class="text-right small"><span class="gry-color small">{{  translate('Order Date') }}:</span>
				    <span class="strong">{{ convert_datetime_to_local_timezone(date('Y-m-d h:i:s', $order->date), user_timezone(Auth::check()?Auth::id():$order->user_id)) }}</span></td>
				</tr>
				@if($order->order_type != 'N' && $order->order_type != 'CW')
				<tr>
					<td class="gry-color small"></td>
					<td class="text-right small"><span class="gry-color small">{{  translate('Order Schedule Time') }}:</span>
					<span class="strong">{{ date(env('DATE_FORMAT').' h:i a', strtotime($order->order_schedule_time)) }}</span></td>
				</tr>
				@endif
				@if($type == 'battery')
				<tr>
					<td class="gry-color small"></td>
					<td class="text-right small"><span class="gry-color small">{{  translate('Service Type') }}:</span>
				    <span class="strong">@if($order->battery_type && $order->battery_type == 'N') New Battery @else Jumpstart @endif</span></td>
				</tr>
				@endif
				@php
					$address = json_decode($order->location);
				@endphp
				@if ($address)
				<tr>
					<td class="gry-color small"></td>
					<td class="text-right small">
					@if($type != 'car_wash')	
					<span class="gry-color small">{{ translate('Customer Location') }}:</span>
					<span class="strong">{{ $address->loc }}</span>
					@endif
					</td>
				</tr>
				@endif
			</table>

		</div>

		<div style="padding: 1rem;padding-bottom: 0">
            <table>
				<tr><td class="strong small gry-color">{{ translate('Bill to') }}:</td></tr>
				<tr><td class="strong">{{ $order->username }}</td></tr>
				<tr><td class="strong">{{ $order->model_name }}</td></tr>
			</table>
		</div>

	    <div style="padding: 1rem;">
			<table class="padding text-left small border-bottom">
				<thead>
	                <tr class="gry-color" style="background: #eceff4;">
	                    <th width="35%" class="text-left">{{ translate('Product Name') }}</th>
	                    <th width="15%" class="text-left">{{ translate('Unit Price') }}</th>
	                    <th width="15%" class="text-left">{{ translate('Total') }}</th>
	                </tr>
				</thead>
				<tbody class="strong">
	                @foreach ($order->orderDetails as $key => $orderDetail)
							<tr>
								<td>
									@if($order->order_type == 'B')	
									@if($order->battery_type == 'N')
									<strong>{{ ($orderDetail->batteryProduct != null)?$orderDetail->batteryProduct->name:translate('Battery Unavailable') }}</strong>
									@else
									Jumpstart
									@endif
									@elseif($order->order_type == 'T')	
									<strong>{{ ($orderDetail->tyreProduct != null)?$orderDetail->tyreProduct->name:translate('Spare Tyre') }}</strong>
									@elseif($order->order_type == 'CW')	
									<strong>{{ ($orderDetail->carwashProduct != null)?$orderDetail->carwashProduct->name:translate('Car Wash') }}</strong>
									@else
									<strong>{{ ($orderDetail->petrolProduct != null)?$orderDetail->petrolProduct->name:translate('Petrol') }}</strong>
									@endif
							    </td>
								<td class="currency">{{ single_price($orderDetail->price) }}</td>
			                    <td class="currency">{{ single_price($orderDetail->price+$orderDetail->tax) }}</td>
							</tr>
					@endforeach
	            </tbody>
			</table>
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
							        <tr>
							            <th class="gry-color text-left">{{ translate('Sub Total') }}</th>
							            <td class="currency">{{ single_price($order->orderDetails->sum('price')) }}</td>
							        </tr>
				                    <tr class="border-bottom">
							            <th class="gry-color text-left">{{ translate('Coupon Discount') }}</th>
							            <td class="currency">{{ single_price($order->coupon_discount) }}</td>
							        </tr>
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
