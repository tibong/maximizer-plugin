jQuery(document).ready(function(){
	var mouse_status="";
	var default_url="";
	var arr  = [];
    jQuery("#sortable1").mouseleave(function() {
        jQuery(".chk").each(function(i) {
			 var new_val = jQuery(this).val();
	  		 // console.log("chl="+i);
	  		 var res = new_val.split("-");
            jQuery(this).val(res[0]+"-"+i+"-1");
		});
	})
    jQuery("#sortable2").mouseleave(function() {
        jQuery(".chk").each(function(i) {
			 var new_val = jQuery(this).val();
	  		 // console.log("chk="+i);
	  		 var res = new_val.split("-");
            jQuery(this).val(res[0]+"-"+i+"-2");
		});
	})
    jQuery(".delete").click(function() {
		var href = jQuery(this).attr('data-href');
		var folder = jQuery(this).attr('folder');
        jQuery("#to_delete").html(folder);
        jQuery('#ok_delete').attr("href", href);
        jQuery('#myModal').modal('toggle');
	});
    jQuery(".das-delete").click(function() {
        var href = jQuery(this).attr('data-href');
        var file = jQuery(this).attr('data-file');
        jQuery("#file_to_delete").html(file);
        jQuery('#ok_file_delete').attr("href", href);
        jQuery('#myModal_file').modal('toggle');
    });
    jQuery(".delete-names-button").click(function(e) {
        e.preventDefault();
        var href = jQuery(this).attr('data-href');
        jQuery('#delete-names').attr("href", href);
        jQuery('#add-names-del').modal('toggle');
    });
    jQuery(".change_field").click(function() {
		var currentval = jQuery(this).val();
		if(currentval == "yes"){
            jQuery(".myurl").attr("readonly", false);
            jQuery(this).val("no");
	     }
	     else{
            jQuery(".myurl").attr("readonly", true);
            jQuery(this).val("yes");
	     }
	});
    jQuery( "#sortable2" ).mousemove(function( event ) {
        mouse_status = "2";
        // jQuery(this).find('.chk').prop("checked", false);
        jQuery(this).find('li').removeClass("maxi");
        //handle drag and drop action
        var new_item = "";
        var new_val = jQuery(this).find('.chk').val();
        var res = new_val.split("-");
        arr.forEach(function(value) {
           if(value != res[0]){
               new_item = res[0];
           }
        });
        if(new_item != ""){
            arr.push(new_item);
        }
        new_item = "";
        // console.log(mouse_status);
    });
    jQuery( "#sortable1" ).mousemove(function( event ) {
        mouse_status = "1";
        jQuery(this).find('li').addClass("maxi");
        // jQuery(this).find('.chk').prop("checked", true);
        // console.log(mouse_status);
    });
    jQuery(".maximizer-box").click(function( event ) {

        //     if (jQuery(this).find('.chk').is(':checked')) {
        //         jQuery(this).find('.chk').prop("checked", false);
        //     } else {
        //         jQuery(this).find('.chk').prop("checked", true);
        //     }
        // if(jQuery(this).find('.chk').click()) {
        //         alert('aw');
        // }
    });
    jQuery(".webforminput").click(function() {
        // alert("haha ataya");
    });
    jQuery('ul.connectedSortable li').mouseleave(function() {
        var new_val = jQuery(this).find('.chk').val();
        var res = new_val.split("-");
        jQuery(this).val(res[0]+"-"+res[1]+"-2");
        var listid = jQuery('#listid-maximizer').val();
        var formid = jQuery('#formid-maximizer').val();
        var desc = jQuery('#desc-maximizer').val();
        var formname = jQuery('#formname-maximizer').val();
        // UpdateData(jQuery(this).find('.chk').val(),listid,formid,desc,formname,mouse_status);
    });
    jQuery('#mailchimp').click(function(){
        console.log(jQuery(this).val());
        if(jQuery(this).val() == 'Yes'){
            jQuery("#mailchimp-text").show();
            default_url = jQuery('#ok_mailchimp_yes').attr('href');
		}else{
            jQuery("#mailchimp-text").hide();
		}
    });
    function UpdateData(id,listid,formid,desc,formname,mouse_status) {
        jQuery.post( "admin.php?page=analytify-dashboard&mypage=maximizer-forms", { ids: id, listid: listid,formid:formid, desc: desc, formname: formname, mouse_status:mouse_status})
            .done(function( data ) {
                console.log("Model Call..");
            });
    }
    jQuery("#form-remove-active").click(function() {
        jQuery("#deactivate-form").prop("checked", true);
        jQuery("#SubmitButton").click();
    });
    jQuery("#form-save-active").click(function() {
        arr.forEach(function(value) {
            console.log(value);
        });
        jQuery('.maxi > .chk').prop("checked", true);
        jQuery("#activate-form").prop("checked", true);
        // jQuery("#SubmitButton").click();
    });
    jQuery(".maximizer-box").on("dragover", function(event) {
        event.preventDefault();
        event.stopPropagation();
        jQuery(this).addClass('dragging');
    });
});