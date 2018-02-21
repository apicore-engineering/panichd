<script src="//cdn.datatables.net/v/bs/dt-{{ PanicHD\PanicHD\Helpers\Cdn::DataTables }}/r-{{ PanicHD\PanicHD\Helpers\Cdn::DataTablesResponsive }}/datatables.min.js"></script>
<script>
	$(function(){
	// Ticket list load
	$('.table').DataTable({
		processing: false,
		serverSide: true,
		responsive: true,
		pageLength: {{ $setting->grab('paginate_items') }},
		lengthMenu: {{ json_encode($setting->grab('length_menu')) }},
		ajax: '{!! route($setting->grab('main_route').'.data', $ticketList) !!}',
		language: {
			decimal:        "{{ trans('panichd::lang.table-decimal') }}",
			emptyTable:     "{{ trans('panichd::lang.table-empty') }}",
			info:           "{{ trans('panichd::lang.table-info') }}",
			infoEmpty:      "{{ trans('panichd::lang.table-info-empty') }}",
			infoFiltered:   "{{ trans('panichd::lang.table-info-filtered') }}",
			infoPostFix:    "{{ trans('panichd::lang.table-info-postfix') }}",
			thousands:      "{{ trans('panichd::lang.table-thousands') }}",
			lengthMenu:     "{{ trans('panichd::lang.table-length-menu') }}",
			loadingRecords: "{{ trans('panichd::lang.table-loading-results') }}",
			processing:     "{{ trans('panichd::lang.table-processing') }}",
			search:         "{{ trans('panichd::lang.table-search') }}",
			zeroRecords:    "{{ trans('panichd::lang.table-zero-records') }}",
			paginate: {
				first:      "{{ trans('panichd::lang.table-paginate-first') }}",
				last:       "{{ trans('panichd::lang.table-paginate-last') }}",
				next:       "{{ trans('panichd::lang.table-paginate-next') }}",
				previous:   "{{ trans('panichd::lang.table-paginate-prev') }}"
			},
			aria: {
				sortAscending:  "{{ trans('panichd::lang.table-aria-sort-asc') }}",
				sortDescending: "{{ trans('panichd::lang.table-aria-sort-desc') }}"
			},
		},
			
		columns: [
			{ data: 'id', name: 'panichd_tickets.id' },
			
			{ data: 'priority_magnitude', name: 'panichd_priorities.magnitude', visible: false },
			{ data: 'updated_at', name: 'panichd_tickets.updated_at', visible: false },
			{ data: 'has_limit', name: 'has_limit', visible: false },
			{ data: 'limit_date', name: 'panichd_tickets.limit_date', visible: false },
			{ data: 'start_date', name: 'panichd_tickets.start_date', visible: false },
			
			{ data: 'subject', name: 'subject' },
			@if ($setting->grab('subject_content_column') == 'no')
				{ data: 'content', name: 'content' },
			@endif
			{ data: 'intervention', name: 'intervention' },
			{ data: 'status', name: 'panichd_statuses.name' },
			@if (session('panichd_filter_agent')=="" && $u->currentLevel() > 1)
				{ data: 'agent', name: 'agent.name' },
			@endif				
			@if( $u->currentLevel() > 1 )
				{ data: 'priority', name: 'panichd_priorities.name', "orderData": [1, 3, 4, 5], "orderSequence": ['desc', 'asc']},
				@if (session('panichd_filter_owner')=="")
					{ data: 'owner_name', name: 'users.name' },
					@if ($setting::grab('departments_feature'))
						{ data: 'dept_info', name: 'dept_full', searchable: false },
					@endif
				@endif
				@if ($ticketList == 'complete')
					{ data: 'complete_date', name: 'completed_at', searchable: false, "orderSequence": [ "desc", "asc"] },
				@else
					{ data: 'calendar', name: 'calendar', searchable: false },
				@endif
			@endif
			{ data: 'updated_at', name: 'panichd_tickets.updated_at' },
			@if( $u->currentLevel() > 1 )
				@if (session('panichd_filter_category')=="")
					{ data: 'category', name: 'panichd_categories.name' },
				@endif
				{ data: 'tags', name: 'panichd_tags.name' }
			@endif				
		],
		@if($ticketList != 'newest')
			@if( $u->currentLevel() > 1)
				@if ($ticketList=='active')
					order: [
						[1, 'desc'],
						[3, 'desc'],
						[4, 'asc'],
						[5, 'asc'],
					]
				@else
					order: [2, 'desc']
				@endif
			@else
				order: [2, 'desc']
			@endif
		@endif
		
	});
	});
</script>