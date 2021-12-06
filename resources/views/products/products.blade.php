@extends('layouts.master')
@section('title')
المنتجات
@endsection
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المنتجات</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row">
				@if($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach($errors->all() as $error)
								<li>{{$error}}</li>
							@endforeach
						</ul>
					</div>
				@endif
				@if (session()->has('Add'))
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<strong>{{ session()->get('Add') }}</strong>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				@endif
				@if (session()->has('edit'))
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<strong>{{ session()->get('edit') }}</strong>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				@endif
				@if (session()->has('delete'))
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<strong>{{ session()->get('delete') }}</strong>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				@endif
					<!--div-->
					<div class="col-xl-12">
						<div class="card mg-b-20">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
										اضافة قسم
									</button>
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="example1" class="table key-buttons text-md-nowrap">
										<thead>
											<tr>
												<th class="border-bottom-0">#</th>
												<th class="border-bottom-0">اسم المنتج</th>
												<th class="border-bottom-0">اسم القسم</th>
												<th class="border-bottom-0">ملاحظات</th>
												<th class="border-bottom-0">العمليات</th>
											</tr>
										</thead>
										<tbody>
											@php($i = 0)
											@foreach($products as $product)
											@php($i++)
											<tr>
												<td>{{$i}}</td>
												<td>{{$product->Product_name}}</td>
												<td>{{$product->section->section_name}}</td>
												<td>{{$product->description}}</td>
												<td>
													<button class="btn btn-outline-success btn-sm"
													data-name="{{ $product->Product_name }}" data-pro_id="{{ $product->id }}"
													data-section_name="{{ $product->section->section_name }}"
													data-description="{{ $product->description }}" data-toggle="modal"
													data-target="#edit_product">تعديل</button>

													<button class="btn btn-outline-danger btn-sm " data-pro_id="{{ $product->id }}"
														data-product_name="{{ $product->Product_name }}" data-toggle="modal"
														data-target="#delete_product">حذف</button>
												</td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
				</div>
				<!-- Modal -->
				<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
							<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<form action="{{route('products.store')}}" method="post">
								@csrf
								<div class="modal-body">
									<div class="form-group">
										<label for="exampleInputEmail1">اسم المنتج</label>
										<input type="text" class="form-control" id="section_name" name="product_name">
									</div>
									<div class="form-group">
										<label for="exampleInputEmail1">اسم القسم</label>
										<select name="section_id">
											<option selected disabled>حدد القسم</option>
											@foreach($sections as $section)
												<option value="{{$section->id}}">{{$section->section_name}}</option>
											@endforeach
										</select>

									</div>
									<div class="form-group">
										<label for="exampleFormControlTextarea1">ملاحظات</label>
										<textarea class="form-control" id="description" name="description" rows="3"></textarea>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
									<button type="submit" class="btn btn-primary">تأكيد</button>
								</div>
							</form>
						</div>
					</div>
				</div>


				<!-- Modal -->
				<div class="modal fade" id="edit_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
							<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<form action="products/update" method="post">
								@method('patch')
								@csrf
								
								<div class="modal-body">
									<input type="hidden" name="pro_id" id="pro_id">
									<div class="form-group">
										<label for="exampleInputEmail1">اسم المنتج</label>
										<input type="text" class="form-control" id="product_name" name="product_name">
									</div>
									<div class="form-group">
										<label for="exampleInputEmail1">اسم القسم</label>
										<select name="section_name" id="section_name">
											<option selected disabled>حدد القسم</option>
											@foreach($sections as $section)
												<option>{{$section->section_name}}</option>
											@endforeach
										</select>

									</div>
									<div class="form-group">
										<label for="exampleFormControlTextarea1">ملاحظات</label>
										<textarea class="form-control" id="description" name="description" rows="3"></textarea>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
									<button type="submit" class="btn btn-primary">تأكيد</button>
								</div>
							</form>
						</div>
					</div>
				</div>

				<div class="modal fade" id="delete_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
							<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<form action="products/destroy" method="post">
								@method('delete')
								@csrf
								<div class="modal-body">
									<p>هل انت متاكد من عملية الحذف ؟</p><br>
									<input type="hidden" name="pro_id" id="pro_id">
									<div class="form-group">
										<label for="exampleInputEmail1">اسم المنتج</label>
										<input type="text" class="form-control" id="product_name" name="product_name" disabled>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
									<button type="submit" class="btn btn-primary">تأكيد</button>
								</div>
							</form>
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
	$('#edit_product').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var Product_name = button.data('name')
		var section_name = button.data('section_name')
		var pro_id = button.data('pro_id')
		var description = button.data('description')
		var modal = $(this)
		modal.find('.modal-body #product_name').val(Product_name);
		modal.find('.modal-body #section_name').val(section_name);
		modal.find('.modal-body #description').val(description);
		modal.find('.modal-body #pro_id').val(pro_id);
	});
	$('#delete_product').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var Product_name = button.data('product_name')
		var pro_id = button.data('pro_id')
		var modal = $(this)
		modal.find('.modal-body #product_name').val(Product_name);
		modal.find('.modal-body #pro_id').val(pro_id);
	});
</script>
@endsection