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
									<h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Events List</h1>
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
										<li class="breadcrumb-item text-muted">Events</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item">
											<span class="bullet bg-gray-200 w-5px h-2px"></span>
										</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item text-dark">Event Listing</li>
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
											<form action="/events" method="get">
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
													<label class="form-label fw-bold">Event Name:</label>
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
												
													<th class="min-w-125px">Id</th>
													<th class="min-w-125px">Event Name</th>
													<th class="min-w-125px">Status</th>
													<th class="text-end min-w-70px">Actions</th>
												</tr>
												<!--end::Table row-->
											</thead>
											<!--end::Table head-->
											<!--begin::Table body-->
											<tbody class="fw-bold text-gray-600">
											    @foreach($event_list as $list)
												<tr>
												
													<td>
														<a href="" class="text-gray-600 text-hover-primary mb-1">{{ $list->id }}</a>
													</td>
												
													<!--begin::Name=-->
													<td>
														<a href="#" class="text-gray-800 text-hover-primary mb-1">{{ $list->event_name }}</a>
													</td>
													<td>
														@if($list->status == 'active')
														<a href="" class="btn btn-sm btn-light-success">{{ $list->status ?? ''}}</a>
														@else
														<a href="" class="btn btn-sm btn-light-danger">{{ $list->status ?? ''}}</a>
														@endif
													</td>
													<td class="text-end" id="show_status">
														
														<a href="/events/view/{{$list->id}}" class="btn btn-sm btn-light-info">View</a>

															<a href="/events/change_status/{{$list->id }}/{{$list->status}}" onclick="return confirm('You Want to Change the Status?')">
															    @if($list->status=='active') 
                                                            <i class="btn btn-sm btn-light-danger">Inactive</i>  
																	
															    @else 
															        <i class="btn btn-sm btn-light-success">Active</i>
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
<script type="text/javascript">
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
</script>