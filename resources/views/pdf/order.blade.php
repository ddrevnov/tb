\
<style>
	body {
		font-family: 'Open Sans', sans-serif;
		src: local(Open Sans), url(href= 'https://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel= 'stylesheet' type= 'text/css');
	}

	table {
		border-collapse: collapse;
		border-bottom: 3px solid #000;
		margin-top: 50px;
		margin-bottom: 8px;
		width: 100%;
		font-size: 14px;
	}

	table h2 {
		margin: 0;
		font-size: 16px;
	}

	td {
		border: 2px solid #ddd;
		vertical-align: top;
		font-weight: bold;
		font-size: 14px;
		padding: 2px;
		font-weight: 500;

	}

	th {
		border: 2px solid #ddd;
		vertical-align: top;
		padding: 2px 4px;
		font-weight: 500;
	}

	th:nth-child(2) {
		width: 110px;
	}

	th:nth-child(3) {
		width: 260px;
	}

	.number {
		text-align: right;
	}
</style>

<div style="padding: 20px;">
	<p style="text-align: right; margin: 0;">
		@if($bank_details->logo)
			<img src="{{public_path() . $bank_details->logo}}" alt="LOGO" style="text-align: right; max-height: 150px;">
		@endif
	</p>
	<p style="font-size: 0; margin-bottom: 60px;">
	<div style="margin-bottom: 10px;">
        <span style="font-size: 9px; border-bottom: 1px solid black; padding: 0 4px;">
            {{$bank_details->firm_name}}, {{$bank_details->street}}, {{$bank_details->post_index}}
        </span>
	</div>
	<span style="font-size: 11px; padding: 0 4px;">{{$firm_details->firm_name}}</span><br>
	<span style="font-size: 11px; padding: 0 4px;">{{$admin_details->firstname}} {{$admin_details->lastname}}</span><br>
	<span style="font-size: 11px; padding: 0 4px;">{{$firm_details->street}}</span><br>
	<span style="font-size: 11px; padding: 0 4px;">{{$firm_details->city}}</span><br>
	<span style="font-size: 11px; padding: 0 4px;">{{$firm_details->country}}</span>
	</p>

	<div style="margin: 20px 0 0 auto; width: 230px; font-size: 14px;">
		<p style="text-align: left; width: 120px; margin: 0; display: inline-block;">Kunden Nr.:</p>
		<p style="width: 100px; margin: 0; text-align: right; display: inline-block;">{{sprintf('T%05u', $admin_details->id)}}</p>
	</div>
	<div style="margin: 0 0 40px auto; width: 230px; font-size: 14px;">
		<p style="text-align: left; width: 120px; margin: 0; display: inline-block;">Datum:</p>
		<p style="width: 100px; margin: 0; text-align: right; display: inline-block;">{{$order_details->created_at}}</p>
	</div>

	<h2 style="font-size: 18px;">Rechnung Nr. {{sprintf('T%05u', $order_details->id)}}</h2>
	<p style="font-size: 14px; margin: 0;">Sehr geehrte(r) {{$admin_details->firstname}} {{$admin_details->lastname}}
	                                       ,</p>
	<p style="font-size: 14px; margin: 0;">anbei erhallten Sie lhre Rechnung mit der Bitte um Zahlung.</p>

	<table>
		<tr>
			<th>Pos</th>
			<th colspan="2">Menge</th>
			<th>Text</th>
			<th>Einzelpreis</br> EUR</th>
			<th>Gesamtpreis</br> EUR</th>
		</tr>
		<tr>
			@if($order_details->orderSMS()->count())
				<td class="number">1</td>
				<td class="number">{{$order_details->orderSMS->count}}</td>
				<td>SMS</td>
				<td>SMS</br>
				    - {{$order_details->orderSMS->package_title}}<br>
				</td>
				<td class="number">{{number_format($order_details->price, 2)}}</td>
				<td class="number">{{number_format($order_details->price, 2)}}</td>
			@else
				<td class="number">1</td>
				<td class="number">1,00</td>
				<td>Stuck</td>
				<td>Tariff</br>
				    - {{$order_details->name}}<br>
				    vom {{$order_details->created_at}}
				    - {{date("t-m-Y", strtotime($order_details->created_at))}}</td>
				<td class="number">{{number_format($order_details->price, 2)}}</td>
				<td class="number">{{number_format($order_details->price, 2)}}</td>
			@endif
		</tr>
		@if($order_details->orderEmployees()->count())
			@foreach($order_details->orderEmployees as $order_employee)
				<tr>
					<td class="number">1</td>
					<td class="number">1,00</td>
					<td>Stuck</td>
					<td>Employee</br>
					    - {{$order_employee->name . ' ' . $order_employee->last_name}}<br>
					    vom {{date('d-m-Y', strtotime($order_employee->created_at))}}
					    - {{date("t-m-Y", strtotime($order_employee->created_at))}}</td>
					<td class="number">{{number_format($order_employee->price, 2)}}</td>
					<td class="number">{{number_format($order_employee->price, 2)}}</td>
				</tr>
			@endforeach
		@endif
		<tr>
			<td colspan="5">Gesant Netto</td>
			<td class="number">{{number_format($order_details->price, 2)}}</td>
		</tr>
		<tr>
			<td colspan="4" style="border-right: 0px solid;">zzgl. 19,00 % USt. auf</td>
			<td style="border-left: 0px solid;" class="number"></td>
			<td class="number">{{number_format($order_details->tax, 2)}}</td>
		</tr>
		<tr>
			<td colspan="5" style="font-weight: 600;"></br><h2>Gesamtbetrag</h2></td>
			<td class="number" style="font-weight: 600;"></br>
				<h2>{{number_format($final_sum, 2)}}</h2></td>
		</tr>
	</table>

	<p style="margin: 8px 0; font-size: 14px;">Zahlbar innerhalb 14 Tagen ohne Abzug</p>
	<p style="margin: 8px 0; font-size: 14px;">Vielen Dank fur lhren Auftrag</p>

	<div style="width: 100%; height: 120px;"></div>

	<div style="border-top: 1px solid #ddd; margin: auto 0 0 0; position: fixed; bottom: 20px;">
		<p style="margin: 8px 0; font-size: 9px;">
			{{$bank_details->firm_name}} &#8226; {{$bank_details->first_last_name}} &#8226; {{$bank_details->street}}
			                             &#8226;

			{{$bank_details->post_index}} &#8226; {{$director_details->phone}} &#8226;

			{{$director_details->email}} &#8226; {{env('MAIN_DOMAIN')}} &#8226; USt-ID {{$bank_details->ust_id}} &#8226;

			                             Handelsregister: {{$bank_details->trade_register}} ·
			                             Steuernummer: {{$bank_details->tax_number}} · {{$bank_details->bank_name}}
			                             &#8226; Bankleitzahl {{$bank_details->bank_code}} &#8226;

			                             Kontonummer {{$bank_details->account_number}} &#8226;
			                             BIC {{$bank_details->bic}} &#8226; IBAN {{$bank_details->iban}} &#8226;
			                             Kontoinhaber {{$bank_details->account_owner}}</p>

	</div>
</div>
