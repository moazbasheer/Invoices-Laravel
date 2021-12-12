@extends('layouts.master')
@section('css')
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('title')
	قائمة الفواتير
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة الفواتير</span>
						</div>
					</div>
					
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row">
				
					<!--/div-->

					<!--div-->
					<div class="col-xl-12">
						<div class="card mg-b-20">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
								@can('اضافة فاتورة')
								<a href="{{route('invoices.create')}}" class="btn btn-primary" >اضافة فاتورة</a>
								@endcan
								@can('تصدير EXCEL')
								<a href="{{route('invoices.export')}}" class="btn btn-primary" >تصدير الي اكسل</a>
								@endcan
								</div>
								<p class="tx-12 tx-gray-500 mb-2">Example of Valex Bordered Table.. <a href="">Learn more</a></p>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="example1" class="table key-buttons text-md-nowrap">
										<thead>
											<tr>
												<th class="border-bottom-0">#</th>
												<th class="border-bottom-0">رقم الفاتورة</th>
												<th class="border-bottom-0">تاريخ الفاتورة</th>
												<th class="border-bottom-0">تاريخ الاستخقاق</th>
												<th class="border-bottom-0">المنتج</th>
												<th class="border-bottom-0">القسم</th>
												<th class="border-bottom-0">الخصم</th>
												<th class="border-bottom-0">نسبة الضريبة</th>
												<th class="border-bottom-0">قيمة الضريبة</th>
												<th class="border-bottom-0">الاجمالي</th>
												<th class="border-bottom-0">الحالة</th>
												<th class="border-bottom-0">ملاحظات</th>
												<th class="border-bottom-0">العمليات</th>
											</tr>
										</thead>
										<tbody>
											@php($i = 1)
											@foreach($invoices as $invoice)
											<tr>
												<td>{{$i++}}</td>
												<td>{{$invoice->invoice_number}}</td>
												<td>{{$invoice->invoice_date}}</td>
												<td>{{$invoice->due_date}}</td>
												<td>{{$invoice->product}}</td>
												<td>{{ $invoice->section->section_name }}</td>
												<td>{{ $invoice->discount }}</td>
												<td>{{ $invoice->rate_vat }}</td>
												<td>{{ $invoice->value_vat }}</td>
												<td>{{ $invoice->total }}</td>
												<td>
													@if ($invoice->Value_Status == 1)
														<span class="text-success">{{ $invoice->status }}</span>
													@elseif($invoice->Value_Status == 2)
														<span class="text-danger">{{ $invoice->status }}</span>
													@else
														<span class="text-warning">{{ $invoice->status }}</span>
													@endif

												</td>

												<td>{{ $invoice->note }}</td>
												<td>
													<div class="dropdown">
														<button aria-expanded="false" aria-haspopup="true"
															class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
															type="button">العمليات<i class="fas fa-caret-down ml-1"></i></button>
														<div class="dropdown-menu tx-13">
															@can('حذف الفاتورة')
															<a class="dropdown-item" href="#" data-invoice_id="{{ $invoice->id }}"
																data-toggle="modal" data-target="#delete_invoice"><i
																	class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;حذف
																الفاتورة</a>
															@endcan
															@can('ارشفة الفاتورة')
																<a class="dropdown-item" href="#" data-invoice_id="{{ $invoice->id }}"
																data-toggle="modal" data-target="#archive_invoice"><i
																	class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;ارشقة
																الفاتورة</a>
															@endcan
															@can('طباعةالفاتورة')
																<a class="dropdown-item" href="/print_invoice/{{$invoice->id}}"><i
																	class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;طباعة
																الفاتورة</a>
															@endcan
														</div>
													</div>
												</td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				<!-- حذف الفاتورة -->
    			<div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
					aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">حذف الفاتورة</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<form action="{{ route('invoices.destroy', 'test') }}" method="post">
										@method('delete')
										@csrf
								
									<div class="modal-body">
										هل انت متاكد من عملية الحذف ؟
										<input type="hidden" name="invoice_id" id="invoice_id" value="">
										<input type="hidden" name="page_id" id="page_id" value="1">
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
										<button type="submit" class="btn btn-danger">تاكيد</button>
									</div>
								</form>
						</div>
					</div>
				</div>
				<div class="modal fade" id="archive_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
					aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">حذف الفاتورة</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<form action="{{ route('invoices.destroy', 'test') }}" method="post">
										@method('delete')
										@csrf
								
									<div class="modal-body">
										هل انت متاكد من عملية الحذف ؟
										<input type="hidden" name="invoice_id" id="invoice_id" value="">
										<input type="hidden" name="page_id" id="page_id" value="2">
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
										<button type="submit" class="btn btn-danger">تاكيد</button>
									</div>
								</form>
						</div>
					</div>
				</div>
				
				</div>
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<script>
	$('#delete_invoice').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var invoice_id = button.data('invoice_id')
		var modal = $(this)
		modal.find('.modal-body #invoice_id').val(invoice_id);
	})
	$('#archive_invoice').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var invoice_id = button.data('invoice_id')
		var modal = $(this)
		modal.find('.modal-body #invoice_id').val(invoice_id);
	})
</script>
@endsection