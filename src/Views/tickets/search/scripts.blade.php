<script type="text/javascript">
// After registering search fields
function success_ajax_callback() {
    // Hide search form
    $('#search_form').hide();

    // Load datatable with the new search fields
    datatable.ajax.reload();

    // Show datatable container
    $('#search_results').show();
}

$(function(){
    /* Category change:
       - checks for permissions in new category
       - updates agent list
       - updates tag list
    */
    $('#select_category').change(function(){
        
        $('#select_category_agent').prop('disabled',true);

        if ($(this).val() == ""){
            // Show visible agents
            $('#select_visible_agent').prop('disabled', false).show();

            // Hide agent list
            $('#select_category_agent').hide();

        }else{
            // Hide visible agents
            $('#select_visible_agent').prop('disabled',true).hide();
            
            // Update agent list
            var loadpage = "{!! route($setting->grab('main_route').'agentselectlist') !!}/" + $(this).val() + "/"+$('#select_category_agent').val();
            $('#select_category_agent').load(loadpage, function(){
                // Show agent select
                $('#select_category_agent').prop('disabled',false).show();
                
                // Default agent has no value
                $('#select_category_agent option[value=auto]').val('').text('- none -');
            });

            // Update tag list
            $('#tag_list_container .select2-container').hide();
            $('#jquery_tag_category_'+$(this).val()).next().show();
        }
    });

    // Date fields with datetimepicker
    @foreach(['created_at', 'completed_at', 'updated_at'] as $date_field)
        $('#{{ $date_field }}').datetimepicker({
            locale: '{{App::getLocale()}}',
            format: '{{ trans('panichd::lang.datetimepicker-format') }}',
            keyBinds: { 'delete':null, 'left':null, 'right':null },
            useCurrent: false
        });

        $('#{{ $date_field }} .btn').click(function(e){
            e.preventDefault();
            $('#' + $(this).closest('.input-group').prop('id')).data("DateTimePicker").toggle();
        });
    @endforeach

    // Edit search button
    $('#edit_search').click(function(e){
        e.preventDefault();

        $('#search_results').hide();
        $('#search_form').slideDown();
    });
});
</script>