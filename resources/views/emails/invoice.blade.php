<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice</title>
    <meta http-equiv="Content-Type" content="text/html;"/>
    <meta charset="UTF-8">
	<style media="all">
		@font-face {
            font-family: 'Roboto';
            src: url("{{ static_asset('fonts/Roboto-Regular.ttf') }}") format("truetype");
            font-weight: normal;
            font-style: normal;
        }
        *{
            margin: 0;
            padding: 0;
            line-height: 1.3;
            font-family: 'Roboto';
            color: #333542;
        }
		body{
			font-size: .875rem;
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
			padding: .5rem .7rem;
		}
		table.padding td{
			padding: .7rem;
		}
		table.sm-padding td{
			padding: .2rem .7rem;
		}
		.border-bottom td,
		.border-bottom th{
			border-bottom:1px solid #eceff4;
		}
		.text-left{
			text-align:left;
		}
		.text-right{
			text-align:right;
		}
		.small{
			font-size: .85rem;
		}
		.currency{

		}
	</style>
</head>
<body>
	<div>
		@php
			$logo = get_setting('header_logo');
		@endphp
			<table>
				<tr>
					<td style="text-align: center">
						<div class="text-center py-4 mb-4">
							<h1 class="h3 mb-3 fw-600">{{ translate('Thank You for Your Order!') }}</h1>
							<h2 class="h5">{{ translate('Order Code:') }} <span
									class="fw-700 text-primary">{{ $order->code }}</span></h2>
						</div>
					</td>
				</tr>
			</table>
			<br>

		<div style="background: #eceff4;padding: 1.5rem;">
			<table>
				<tr>
					<td style="text-align: center">
						@if($logo != null)
							<img loading="lazy" src="{{ uploaded_asset($logo) }}" height="40" style="display:inline-block;">
						@else
							<img loading="lazy" src="{{ static_asset('assets/img/logo.png') }}" height="40" style="display:inline-block;">
						@endif
					</td>
				</tr>
			</table>
			<br>
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
				<br>
				<br>
				<tr>
					<td class="gry-color small">{{  translate('Email') }}: {{ get_setting('contact_email') }}</td>
					<td class="text-right small"><span class="gry-color small">{{  translate('Order Code') }}:</span> <span class="strong">{{ $order->code }}</span></td>
				</tr>
				<tr>
					<td class="gry-color small">{{  translate('Phone') }}: {{ get_setting('contact_phone') }}</td>
					<td class="text-right small"><span class="gry-color small">{{  translate('Order Date') }}:</span> <span class=" strong">{{ convert_datetime_to_local_timezone(date('Y-m-d h:i:s', $order->date), user_timezone(Auth::check()?Auth::id():$order->user_id)) }}</span></td>
				</tr>
			</table>
		</div>
	</div>
</body>
</html>
