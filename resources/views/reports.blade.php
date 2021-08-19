<!DOCTYPE html>
<html>
<head>
	<title>Отчеты</title>
	 <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

</head>
<body>
	<div class="row">
		<h4>{{ $status ?? '' }}</h4>
	</div>
	<div class="row">
		<form action="/reports" method="post" enctype="multipart/form-data">
			@csrf
		  <div class="mb-3">
		    <label for="exampleInputEmail1" class="form-label">Выберите отчет (.csv):
		    <input type="file" class="form-control" id="file" name="csv_upload_file" aria-describedby="file" accept=".csv" ></label>
		  </div>

		  <button type="submit" class="btn btn-primary">Загрузить</button>
		</form>
	</div>
	<div class="row p-3">
		@foreach ($reports as $report)
		<div class="">
			<h5><b>Дата импорта отчета:</b> {{$report['date'] ?? ''}}</h5>
			<table class="table">
				<thead>
					<tr>
						<th>Статус аккаунта</th>
						<th>Название аккаунта</th>
						<th>Идентификатор внешнего клиента (аккаунт)</th>
						<th>Имя ответственного менеджера</th>
						<th>Идентификатор клиента (ответственный менеджер)</th>
						<th>Тип аккаунта</th>
						<th>Kлики</th>
						<th>Показы</th>
						<th>CTR</th>
						<th>Код валюты</th>
						<th>Средняя цена за клик</th>
						<th>Код валюты после конвертации</th>
						<th>Средняя цена за клик (валюта после конвертации)</th>
						<th>Расходы</th>
						<th>Стоимость (валюта после конвертации)</th>
						<th>Конверсии</th>
						<th>Коэфф. конверсии</th>
						<th>Ярлыки аккаунта</th>
					</tr>
				</thead>

				<tbody>
					@foreach($report['csv_rows_array'] as $row)
						<tr>
							<td><span class="fs-6">{{$row['status'] ?? ''}}</span></td>
							<td><span class="fs-6">{{$row['account_name'] ?? ''}}</span></td>
							<td><span class="fs-6">{{$row['outter_id_client'] ?? ''}}</span></td>
							<td><span class="fs-6">{{$row['manager_name'] ?? ''}}</span></td>
							<td><span class="fs-6">{{$row['manager_id'] ?? ''}}</span></td>
							<td><span class="fs-6">{{$row['account_type'] ?? ''}}</span></td>
							<td><span class="fs-6">{{$row['clicks'] ?? ''}}</span></td>
							<td><span class="fs-6">{{$row['shows'] ?? ''}}</span></td>
							<td><span class="fs-6">{{$row['ctr'] ?? ''}}</span></td>
							<td><span class="fs-6">{{$row['curency_code'] ?? ''}}</span></td>
							<td><span class="fs-6">{{$row['average_price_per_click'] ?? ''}}</span></td>
							<td><span class="fs-6">{{$row['currency_code_after_converter'] ?? ''}}</span></td>
							<td><span class="fs-6">{{$row['average_price_per_click_after_converter'] ?? ''}}</span></td>
							<td><span class="fs-6">{{$row['expences'] ?? ''}}</span></td>
							<td><span class="fs-6">{{$row['cost_currency_after_converter'] ?? ''}}</span></td>
							<td><span class="fs-6">{{$row['conversions'] ?? ''}}</span></td>
							<td><span class="fs-6">{{$row['coefficent_conversions'] ?? ''}}</span></td>
							<td><span class="fs-6">{{$row['account_label'] ?? ''}}</span></td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<hr>
		@endforeach
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

</body>
</html>