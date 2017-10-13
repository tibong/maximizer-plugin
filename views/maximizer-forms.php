<div class='container'>
    <h1>Maximizer web to lead forms </h1>
    <div class='panel panel-default'>
      <div class='panel-heading'><h3>From View</h3></div>
      <div class="pull-right">
            <a href="admin.php?page=analytify-dashboard&mypage=maximizer-generate-list&listid=<?php echo $_GET['listid'];?>&formid=<?php echo $_GET['formid'];?>&desc=<?php echo $_GET['desc'];?>"  class="btn btn-default btn-sm">BACK</a>
      </div>
      <script type="text/javascript">
         jQuery(document).ready(function($){
             $( "#sortable1, #sortable2" ).sortable({
                  connectWith: ".connectedSortable"
              }).disableSelection();
             $( "#droppable2, #droppable" ).droppable({
                 drop: function( event, ui ) {
                     console.log('awwweeee'+$(this).find( "> .chk" ).val());
                 }
             });
          });
      </script>
      <!-- main -->
      	<div id="form-activate">
          <div class='panel-body'>
              <form method='POST' id="form-lists-maximizer" action='admin.php?page=analytify-dashboard&mypage=maximizer-forms&listid=<?php echo $_GET['listid'];?>&formid=<?php echo $_GET['formid'];?>&formname=<?php echo $_GET['formname'];?>'>
                <div class='col-md-12'>
                  	<div class='form-group col-md-12'>  
                    	   <span class='webformlabel'>Form Name</span>
                        <input type="text" class="form-control" id = "formname-maximizer" required value="<?php if(isset($_POST['update'])){echo $_POST['formName'];}else{echo $_GET['formname'];}?>" name="formName" />
                    </div>  
                </div>
                <?php   
                  global $wpdb;    
                  $rad_results = $wpdb->get_results("SELECT category_id,generated_id FROM wp_generated WHERE generated_id =".$_GET['formid']); 
                 ?>
                <div class='col-md-6'>
                  <div class='form-group col-md-12'>  
                       <div class = "panel panel-success">
                        <div class = "panel-heading">
                            <h3 class = "panel-title">Form action type <span class="label label-danger"> required</span></h3>
                        </div>
                        <div class = "panel-body">
                          <input type="radio" name="type" value="1" checked <?php if($rad_results[0]->category_id=="1"){ echo "checked";} ?> required /> Company and contacts
                          <input type="radio" name="type" value="2" <?php if($rad_results[0]->category_id=="2"){ echo "checked";} ?> /> Individuals
                        </div>
                     </div>
                  </div>
                  <div class='form-group' style="display: none;">  
                     <input type="text" id="listid-maximizer" name="listid"  value="<?php echo $_GET['listid'];?>"/>
                  </div>
                  <div class='form-group' style="display: none;">  
                     <input type="text" id="formid-maximizer" name="formid"  value="<?php echo $_GET['formid'];?>"/>
                  </div>
                  <div class='form-group' style="display: none;">  
                     <input type="text" id="desc-maximizer" name="desc"  value="<?php echo $_GET['desc'];?>"/>
                  </div> 
                <div class='col-md-6'>
                <!-- start -->
                <div class = "panel panel-success">
                  <div class = "panel-heading">
                    <h3 class = "panel-title"> Active</h3>
                  </div>
                  <div class = "panel-body">
                    <ul id="sortable1" class="connectedSortable">
                    <?php 
                      global $wpdb;  
                      $res="";
                      $active="";
                      $desc="";
                      $type="submit";
                      if(isset($_GET['formid'])){
                          $query = "SELECT * FROM wp_activated  LEFT JOIN  wp_maximizer  ON wp_maximizer.id = wp_activated.fields_id WHERE wp_activated.generated_id=".$_GET['formid']." AND wp_maximizer.account_id=".$_GET['listid']." AND wp_activated.status=1 ORDER BY wp_activated.field_position ASC";
                          $res= $wpdb->get_results($query);
                          $type="update";
                      }else{
                           //$res = $wpdb->get_results("SELECT givenname,description,name,id FROM wp_maximizer WHERE account_id=".$_GET['listid']);  
                      }
                       if(!empty($res)) { 
                         foreach($res as $r) {
                                      $starstar = '';
                                      $result_generated = $wpdb->get_results("SELECT account_id,fields_id,display_name,mandatory FROM wp_maximizer_settings_fields WHERE account_id = ".$_GET['listid']." AND fields_id='".$r->id."'"); 
                                       if(!empty($result_generated)) { 
                                          if($result_generated[0]->display_name!=""){
                                              $desc = $result_generated[0]->display_name;
                                          }else{
                                              $desc = $r->description;
                                          }
                                       }else{
                                          $desc = $r->description;
                                       }
                                       if($result_generated[0]->mandatory == '1'){
                                            $required="required";
                                            $starstar = '*';
                                        }
                                       echo"<li class='ui-state-default maxi maximizer-box' id='droppable'><input type='checkbox' class='chk' name='$r->name' $required  value='$r->id'><span class='webformlabel ui-icon ui-icon-arrowthick-2-n-s'> $desc <span class='mandatorymarker'>".$starstar."</span></span></li>";
                                       $active=""; 
                        }  
                      }
                      ?>
                  </ul>
                </div>
                 <div class='panel-footer'>
                  <div class='form-group' style="display: none">
                      <input type="radio" id="activate-form" name="activate" value="1" checked> Activate
                      <input type="radio" id="deactivate-form" name="activate" value="0"> Deactivate
                  </div>
                   <div class='form-group'>
<!--                    <input class='submitbutton btn btn-primary' data-toggle="modal" data-target="#myModal_loading" name="--><?php //echo $type;?><!--"   type='submit' id='SubmitButton' value='submit'/>-->
                       <button type='button' id="form-save-active" class='submitbutton btn btn-info'> Save</button>
                       <button type='button' id="form-remove-active" class='submitbutton btn btn-warning'> Remove</button>
                  </div> 
                </div>
              </div>
              </div>
<!--      end of active forms        -->
               <div class='col-md-6'>
               <!-- passive -->
               <?php  ?>
               <div class = "panel panel-success">
                  <div class = "panel-heading">
                    <h3 class = "panel-title">Inactive</h3>
                  </div>
                  <div class = "panel-body">
                    <ul id="sortable2" class="connectedSortable">
                    <?php
                     $results2="";
                     $desc2="";
                     $active2="";
                     $starstar2="";
                    if(isset($_GET['formid'])){
                           $query2 = "SELECT givenname,id,name,description FROM  wp_maximizer l WHERE  NOT EXISTS (SELECT generated_id,fields_id,status FROM  wp_activated i WHERE  l.id = i.fields_id AND  i.status != 0 AND i.generated_id = ".$_GET['formid'].") AND l.account_id=".$_GET['listid'];
                           $results2 = $wpdb->get_results($query2);
                    }else{
                           $results2 = $wpdb->get_results("SELECT givenname,description,name,id FROM wp_maximizer WHERE account_id=".$_GET['listid']);
                    } 
                    foreach($results2 as $val){                
                          $result2_generated = $wpdb->get_results("SELECT account_id,fields_id,display_name,mandatory FROM wp_maximizer_settings_fields WHERE account_id = ".$_GET['listid']." AND fields_id=".$val->id); 
                           if(!empty($result2_generated)) { 
                               if($result2_generated[0]->display_name!=""){
                                    $desc2 = $result2_generated[0]->display_name;
                                }else{
                                    $desc2 = $val->description;
                                }
                           }else{
                              $desc2 = $val->description; 
                           }
                            if($result2_generated[0]->mandatory == '1'){
                                $required="required";
                                $starstar2 = '*';
                            }
                        echo("<li class='ui-state-highlight maximizer-box' id='droppable2'><input type='checkbox' class='chk' $active2 name='$val->name' value='$val->id'/><span class='webformlabel ui-icon ui-icon-arrowthick-2-n-s'> ".$desc2." <span class='mandatorymarker'>".$starstar2."</span></span></li>");
                      $desc2="";
                      $active2="";
                      $starstar2="";
                    }
                    ?>
                    </ul>
                  </div>
                   <div class='panel-footer'>
                       <div class='form-group'>
                           <input class='submitbutton btn btn-primary' data-toggle="modal" data-target="#myModal_loading" name="<?php echo $type;?>"   type='submit' id='SubmitButton' value='submit'/>
<!--                           <button type='button' id="form-remove-active" class='submitbutton btn btn-warning'> Remove</button>-->
                       </div>
                   </div>
                </div>
                <?php  ?>
              </div>
              </form>
            </div>
            <div class='col-md-6'>
            
            <div class = "panel panel-success">
               <div class = "panel-heading">
                  <h3 class = "panel-title">Form Preview</h3>
               </div>
               <div class = "panel-body">
               <h1 style="text-align:center"><?php if(isset($_POST['update'])){echo $_POST['formName'];}else{echo $_GET['formname'];}?></h1>  
                <?php 
                    $desc3="";
                    $query = "SELECT * FROM wp_activated  LEFT JOIN  wp_maximizer  ON wp_maximizer.id = wp_activated.fields_id WHERE wp_activated.generated_id=".$_GET['formid']." AND wp_activated.status=1 ORDER BY wp_activated.field_position ASC";
                    $res= $wpdb->get_results($query);
                    foreach($res as $r) {
                      $result3_generated = $wpdb->get_results("SELECT account_id,fields_id,display_name,mandatory FROM wp_maximizer_settings_fields WHERE account_id = ".$_GET['listid']." AND fields_id='".$r->id."'"); 
                             if(!empty($result3_generated)) { 
                                if($result3_generated[0]->display_name!=""){
                                    $desc3 = $result3_generated[0]->display_name;
                                }else{
                                    $desc3 = $r->description;
                                }
                             }else{
                                $desc3 = $r->description;
                             }
                ?>
                    <div class='form-group'>
                      <span class='webformlabel'><?php echo $desc3; ?></span>
                      <input class="form-control" readonly name='' type='text'><br>
                    </div>
                <?php
                       $desc3="";
                     }
                ?>
                 <div class='form-group'>
                <?php if(isset($_GET['formid'])){ ?>
                            <div style="text-align:center"><input class="btn btn-info" type="submit" id="SubmitButton" value="Submit"/></div>
                 <?php }else{ ?>
                            <p align="center">The form generated will be displayed here..</p>
                 <?php } ?>
                 </div>
               </div>
            </div>
            </div>
            <div class="col-md-12">
        </div>
      </div>
    </div>
  </div>