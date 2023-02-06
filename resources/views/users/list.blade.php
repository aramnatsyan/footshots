@extends('layouts.base')

@section('content')

														
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Toolbar-->
						<div class="toolbar" id="kt_toolbar">
							<!--begin::Container-->
							<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
								<!--begin::Page title-->
								<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
									<!--begin::Title-->
									<h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Users List</h1>
									<!--end::Title-->
									<!--begin::Separator-->
									<span class="h-20px border-gray-200 border-start mx-4"></span>
									<!--end::Separator-->
									<!--begin::Breadcrumb-->
									<ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
										<!--begin::Item-->
										<li class="breadcrumb-item text-muted">
											<a href="/home" class="text-muted text-hover-primary">Home</a>
										</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item">
											<span class="bullet bg-gray-200 w-5px h-2px"></span>
										</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item text-muted">Users</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item">
											<span class="bullet bg-gray-200 w-5px h-2px"></span>
										</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item text-dark">User Listing</li>
										<!--end::Item-->
									</ul>
									<!--end::Breadcrumb-->
								</div>
								<!--end::Page title-->
								<!--begin::Actions-->
								<div class="d-flex align-items-center py-1">
									<!--begin::Wrapper-->
									<div class="me-4">
										<!--begin::Menu-->
										<a href="#" class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
										<!--begin::Svg Icon | path: icons/duotone/Text/Filter.svg-->
										<span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24" />
													<path d="M5,4 L19,4 C19.2761424,4 19.5,4.22385763 19.5,4.5 C19.5,4.60818511 19.4649111,4.71345191 19.4,4.8 L14,12 L14,20.190983 C14,20.4671254 13.7761424,20.690983 13.5,20.690983 C13.4223775,20.690983 13.3458209,20.6729105 13.2763932,20.6381966 L10,19 L10,12 L4.6,4.8 C4.43431458,4.5790861 4.4790861,4.26568542 4.7,4.1 C4.78654809,4.03508894 4.89181489,4 5,4 Z" fill="#000000" />
												</g>
											</svg>
										</span>
										<!--end::Svg Icon-->Filter</a>
										<!--begin::Menu 1-->
										<div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true">
											<!--begin::Header-->
											<div class="px-7 py-5">
												<div class="fs-5 text-dark fw-bolder">Filter Options</div>
											</div>
											<!--end::Header-->
											<!--begin::Menu separator-->
											<div class="separator border-gray-200"></div>
											<!--end::Menu separator-->
											<form action="/users" method="get">
												<!-- @csrf -->
											<!--begin::Form-->
											<div class="px-7 py-5">
												<!--begin::Input group-->
												<div class="mb-10">
													<!--begin::Label-->
													<label class="form-label fw-bold">View:</label>
													<!--end::Label-->
													<!--begin::Input-->
													<div>
														<select class="form-select form-select-solid" data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true" name="view">
															<option></option>
															<option value="list_view">List View</option>
															<option value="grid_view">Grid View</option>
															
														</select>
													</div>
													<!--end::Input-->
												</div>
                                                
<!--                                                 <div class="mb-10">
    <label class="form-label fw-bold">Range Picker:</label>
    <div class="col-lg-4 col-md-9 col-sm-12">
     <div class="input-daterange input-group" id="kt_datepicker_5">
      <input type="text" class="form-control" name="start"/>
      <div class="input-group-append">
       <span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
      </div>
      <input type="text" class="form-control" name="end"/>
     </div>
     <span class="form-text text-muted">Linked pickers for date range selection</span>
    </div>
   </div> -->
                                            <div class="mb-10">
                                            <label class="form-label fw-bold">From Date:</label>
                        <div class="form-group">
                          <input type="date"  id="from-datepicker" class="form-control" name="from" value="" placeholder="from date" readonly="from" />
                        </div>
                      </div>
                     
                      <div class="mb-10">
                      <label class="form-label fw-bold">To Date:</label>
                        <div class="form-group">
                          <input type="date"  id="from-datepicker1" class="form-control" name="to" value="" placeholder="to date" readonly="to"/>
                        </div>  
                      </div>
                                                <div class="mb-10">
													<!--begin::Label-->
													<label class="form-label fw-bold">Name:</label>
													<!--end::Label-->
													<!--begin::Input-->
													<div>
														<input type="text" class="form-control" name="name"/>
													</div>
													<!--end::Input-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												
												<!--end::Input group-->
												<!--begin::Input group-->
												
												<!--end::Input group-->
												<!--begin::Actions-->
												<div class="d-flex justify-content-end">
													<!-- <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">Reset</button> -->
													<button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Apply</button>
												</div>
												<!--end::Actions-->
											</div>
											</form>
											<!--end::Form-->
										</div>
										<!--end::Menu 1-->
										<!--end::Menu-->
									</div>
									<!--end::Wrapper-->
									<!--begin::Button-->
									<!-- <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app" id="kt_toolbar_primary_button">Create</a> -->
									<!--end::Button-->
								</div>
								<!--end::Actions-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Toolbar-->
						<!--begin::Post-->
						<div class="post d-flex flex-column-fluid" id="kt_post">
							<!--begin::Container-->
							<div id="kt_content_container" class="container">
								<!--begin::Card-->
								<div class="card">
									<!--begin::Card header-->
									<div class="card-header border-0 pt-6">
										<!--begin::Card title-->
										<div class="card-title">
											<!--begin::Search-->
											<div class="d-flex align-items-center position-relative my-1">
												<!--begin::Svg Icon | path: icons/duotone/General/Search.svg-->
												<!-- <span class="svg-icon svg-icon-1 position-absolute ms-6">
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
														<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24" />
															<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
															<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
														</g>
													</svg>
												</span> -->
												<!--end::Svg Icon-->
												<!-- <input type="text" data-kt-customer-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Customers" /> -->
											</div>
											<!--end::Search-->
										</div>
										<!--begin::Card title-->
										<!--begin::Card toolbar-->
										<div class="card-toolbar">
											<!--begin::Toolbar-->
											
											<!--end::Toolbar-->
											<!--begin::Group actions-->
											
											<!--end::Group actions-->
										</div>
										<!--end::Card toolbar-->
									</div>
									<!--end::Card header-->
									<!--begin::Card body-->
									<div class="card-body pt-0">
										<!--begin::Table-->
										<table class="table table-bordered align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
											<!--begin::Table head-->
											<thead>
												<!--begin::Table row-->
												<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
													<!-- <th class="w-10px pe-2">
														<div class="form-check me-3">
															<input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_customers_table .form-check-input" value="1" />
														</div>
													</th> -->
													
													<th class="min-w-125px">Id</th>
<!-- 													<th class="min-w-125px">Profile Picture</th> -->
													<th class="min-w-125px">Name</th>
													<th class="min-w-125px">Email</th>
													<th class="min-w-125px">Total Events</th>
													<th class="min-w-125px">Status</th>
													<!-- <th class="min-w-125px">Created Date</th> -->
													<th class="text-end min-w-70px">Actions</th>
												</tr>
												<!--end::Table row-->
											</thead>
											<!--end::Table head-->
											<!--begin::Table body-->
											<tbody class="fw-bold text-gray-600">
												@foreach($lists as $list)
												<tr>
													<!--begin::Checkbox-->
												<!-- 	<td>
														<div class="form-check form-check-sm form-check-custom form-check-solid">
															<input class="form-check-input" type="checkbox" value="1" />
														</div>
													</td> -->
													<!--end::Checkbox-->
													<td>
														<a href="" class="text-gray-600 text-hover-primary mb-1">{{ $list->id ?? ''}}</a>
													</td>
<!-- 													<td>
														<div class="symbol symbol-45px me-5">
                                                            @if($list->pic)
                                                             <img src="{{ url($list->pic)  ?? '' }}" alt="" />
                                                            @else
                                                            <img src="{{ url('assets/media/avatars/blank.png')}}" alt="" />
                                                            @endif
                                                        </div>
													</td> -->
													
													<!--begin::Name=-->
													<td>
                                                    	<div class="symbol symbol-45px me-5">
                                                            @if($list->pic)
                                                             <img src="{{ url($list->pic)  ?? '' }}" alt="" />
                                                            @else
                                                            <img src="{{ url('assets/media/avatars/blank.png')}}" alt="" />
                                                            @endif
                                                        </div>
														<a href="#" class="text-gray-800 text-hover-primary mb-1">{{ ucfirst($list->username )  ?? '' }}</a>
													</td>
													<td>
														<a href="" class="text-gray-600 text-hover-primary mb-1">{{ $list->email ?? ''}}</a>
													</td>
													<td>
														<a href="" class="btn btn-sm btn-light-success">{{ $list->total_event ?? ''}}</a>
													</td>
													<td>
														@if($list->status == 'active')
                                                    <span class="btn btn-sm btn-light-success">  {{ $list->status ?? ''}}</span>
														@else
                                                    <span class="btn btn-sm btn-light-danger">  {{ $list->status ?? ''}}</span>
													
														@endif

													</td>
													<!--end::Name=-->
													<!--begin::Email=-->
													
													<!--end::Email=-->
													<!--begin::Company=-->
													<!-- <td>@if($list->date_of_birth)

                                                                        {{  date('d M Y',strtotime($list->date_of_birth))   }}
                                                                        @endif</td> -->
													<!--end::Company=-->
													
													<!--begin::Date=-->
													<!-- <td>
														@if($list->created_at)
														   {{  date('d M Y h:i:a',strtotime($list->created_at))   
														}}
                                                        @endif
                                                    </td> -->
													<!--end::Date=-->
													<!--begin::Action=-->
													<td class="text-end" id="show_status_{{$list->id}}">
														
														<a href="/user/view/{{$list->id}}" class="btn btn-sm btn-light-info">View</a>

														<!-- @if($list->status =='active')
															<a href="javascript:void(0);" onclick="change_status('{{$list->id}}','{{$list->status}}');" class="btn btn-sm btn-light-success">Active</a>
														@else
															<a href="javascript:void(0);" onclick="change_status('{{$list->id}}','{{$list->status}}');" class="btn btn-sm btn-light-danger" data-kt-customer-table-filter="delete_row">Inactive</a>
														@endif -->
															<a href="/users/change_status/{{$list->id }}/{{$list->status}}" onclick="return confirm('You Want to Change the Status?')">
															    @if($list->status=='active') 
                                                                     <span class="btn btn-sm btn-light-danger">Inactive</span> 
																
															    @else 
															        	<span class="btn btn-sm btn-light-success">Active</span>
															    @endif
														    </a>
															
													</td>
										
													<!--end::Action=-->
												</tr>
												@endforeach
											</tbody>
											<!--end::Table body-->

											
										</table>
										<!--end::Table-->
										{{ $lists->links() }}
									</div>
									<!--end::Card body-->
								</div>
								<!--end::Card-->
								  </div>

                                                <!--end::Table container-->
                              </div>
                                            <!--begin::Body-->

                    </div>
                                        <!--end::Tables Widget 9-->
                               	 

@endsection       


@section('scripts')
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.min.js"></script> -->

    <script>
$(document).ready(function() {
    $("#from-datepicker").datepicker({ 
        format: 'yyyy-mm-dd'
    });
    $("#from-datepicker").on("change", function () {
        var fromdate = $(this).val();
        
    });
}); 
</script>
<!-- <script>

ar KTBootstrapDatepicker = function () {

 var arrows;
 if (KTUtil.isRTL()) {
  arrows = {
   leftArrow: '<i class="la la-angle-right"></i>',
   rightArrow: '<i class="la la-angle-left"></i>'
  }
 } else {
  arrows = {
   leftArrow: '<i class="la la-angle-left"></i>',
   rightArrow: '<i class="la la-angle-right"></i>'
  }
 }

 // Private functions
 var demos = function () {

  // range picker
  $('#kt_datepicker_5').datepicker({
   rtl: KTUtil.isRTL(),
   todayHighlight: true,
   templates: arrows
  });

  
 }

 return {
  // public functions
  init: function() {
   demos();
  }
 };
}();

jQuery(document).ready(function() {
 KTBootstrapDatepicker.init();
});
</script>
 -->
<!-- <script type="text/javascript">
    function change_status(id,status)
  {
     // alert(status);
     var token = '{{ csrf_token() }}';
     if(status == 'active')
     {
       if(confirm("Are you sure you want to inactive."))
       { 
        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: "POST",
                url: "/change_status",
                data: {id:id,status:'inactive'},
                success: function(result){
                        console.log(result);  
                
               $('#show_status_'+id).html('<a href="javascript:void(0);" onclick="change_status("'+id+'","'+result.status+'");" class="label label-lg font-weight-bold label-inline label-light-danger">Inactive</a>');
                }
          });
        }
      }
      else
      {
      	if(confirm("Are you sure you want to active."))
        { 
           $.ajax({
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: "POST",
                url: "/change_status",
                data: {id:id,status:'active'},
                success: function(result){
                     console.log(result);    
$('#show_status_'+id).html('<a href="javascript:void(0);" onclick="change_status("'+id+'","'+result.status+'");" class="label label-lg font-weight-bold label-inline label-success">Active </a>');                }
          });
        }
      }
    
    }
</script> -->