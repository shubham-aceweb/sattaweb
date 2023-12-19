$( document ).ready(function() {  
  /*
  * Replace underscore to space script 
  */
  $('.txtwithoutsymble').each(function() {
        $(this).find('span').each(function(){
           var newText = $(this).text().replace(/_/g, ' ');
           $(this).text(newText.charAt(0).toUpperCase() + newText.slice(1));
        });
  });

  /*
  * Excel Export Select Option Script 
  */
  $('#other_option').change(function () {
      var selectdata=$(this).val();
      if(selectdata == 'select_date')
      {
          $("#SelectedDatetable").show();
          $("#startdate").hide(); 
          $("#enddate").hide(); 
      }else if(selectdata == 'all_date'){
          $("#SelectedDatetable").hide(); 
          $("#startdate").hide(); 
          $("#enddate").hide(); 
      }else if(selectdata == 'today'){
          $("#SelectedDatetable").hide(); 
          $("#startdate").hide(); 
          $("#enddate").hide(); 
      }
      else
      {
        $("#SelectedDatetable").hide(); 
          $("#startdate").show(); 
          $("#enddate").show();  
      }
    });
  

  $('#other_option_1').change(function () {
      var selectdata=$(this).val();
      //var dataexport=$(this).attr('dataexport');

      if(selectdata == 'select_date')
      {
          $("#SelectedDatetable_user").show();
          $("#startdate_user").hide(); 
          $("#enddate_user").hide(); 
      }else if(selectdata == 'all_date'){
          $("#SelectedDatetable_user").hide(); 
          $("#startdate_user").hide(); 
          $("#enddate_user").hide(); 
      }else if(selectdata == 'today'){
          $("#SelectedDatetable_user").hide(); 
          $("#startdate_user").hide(); 
          $("#enddate_user").hide(); 
      }
      else
      {
          $("#SelectedDatetable_user").hide(); 
          $("#startdate_user").show(); 
          $("#enddate_user").show();  
      }
    });


    $('#other_option_2').change(function () {
      var selectdata=$(this).val();
      //var dataexport=$(this).attr('dataexport');

      if(selectdata == 'select_date')
      {
          $("#SelectedDatetable_lead").show();
          $("#startdate_lead").hide(); 
          $("#enddate_lead").hide(); 
      }else if(selectdata == 'all_date'){
          $("#SelectedDatetable_lead").hide(); 
          $("#startdate_lead").hide(); 
          $("#enddate_lead").hide(); 
      }else if(selectdata == 'today'){
          $("#SelectedDatetable_lead").hide(); 
          $("#startdate_lead").hide(); 
          $("#enddate_lead").hide(); 
      }
      else
      {
          $("#SelectedDatetable_lead").hide(); 
          $("#startdate_lead").show(); 
          $("#enddate_lead").show();  
      }
    });

    $('#other_option_3').change(function () {
      var selectdata=$(this).val();
      //var dataexport=$(this).attr('dataexport');

      if(selectdata == 'select_date')
      {
          $("#SelectedDatetable_click").show();
          $("#startdate_click").hide(); 
          $("#enddate_click").hide(); 
      }else if(selectdata == 'all_date'){
          $("#SelectedDatetable_click").hide(); 
          $("#startdate_click").hide(); 
          $("#enddate_click").hide(); 
      }else if(selectdata == 'today'){
          $("#SelectedDatetable_click").hide(); 
          $("#startdate_click").hide(); 
          $("#enddate_click").hide(); 
      }
      else{
          $("#SelectedDatetable_click").hide(); 
          $("#startdate_click").show(); 
          $("#enddate_click").show();  
      }
    });


    $('#other_option_4').change(function () {
      var selectdata=$(this).val();
      //var dataexport=$(this).attr('dataexport');

      if(selectdata == 'select_date')
      {
          $("#SelectedDatetable_tran").show();
          $("#startdate_tran").hide(); 
          $("#enddate_tran").hide(); 
      }else if(selectdata == 'all_date'){
          $("#SelectedDatetable_tran").hide(); 
          $("#startdate_tran").hide(); 
          $("#enddate_tran").hide(); 
      }else if(selectdata == 'today'){
          $("#SelectedDatetable_tran").hide(); 
          $("#startdate_tran").hide(); 
          $("#enddate_tran").hide(); 
      }
      else{
          $("#SelectedDatetable_tran").hide(); 
          $("#startdate_tran").show(); 
          $("#enddate_tran").show();  
      }
    });

    $('#other_option_5').change(function () {
      var selectdata=$(this).val();
      //var dataexport=$(this).attr('dataexport');

      if(selectdata == 'select_date')
      {
          $("#SelectedDatetable_exl_upl").show();
          $("#startdate_exl_upl").hide(); 
          $("#enddate_exl_upl").hide(); 
      }else if(selectdata == 'all_date'){
          $("#SelectedDatetable_exl_upl").hide(); 
          $("#startdate_exl_upl").hide(); 
          $("#enddate_exl_upl").hide(); 
      }else if(selectdata == 'today'){
          $("#SelectedDatetable_exl_upl").hide(); 
          $("#startdate_exl_upl").hide(); 
          $("#enddate_exl_upl").hide(); 
      }
      else{
          $("#SelectedDatetable_exl_upl").hide(); 
          $("#startdate_exl_upl").show(); 
          $("#enddate_exl_upl").show();  
      }
    });
  
});

function isNumberKey(event) {
    const charCode = event.which ? event.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}  