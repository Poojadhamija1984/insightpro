<!DOCTYPE html>
<html>
<?php $this->load->view('common/head_view') ?>
    <body>
        <div class="page-wrapper">
            <!-- HEADER SECTION START-->
            <?php $this->load->view('common/header_view') ?>
            <!-- HEADER SECTION END-->
            <!-- SIDEBAR SECTION START -->
            <?php $this->load->view('common/sidebar_view') ?>
            <!-- SIDEBAR SECTION END -->
            <!-- MAIN SECTION START -->
            <main>
                <!-- MAIN CONTENTS START -->
                <div class="main-contents">
                    <!-- BREADCRUMB SECTION START -->
                    <div class="breadcrumb-section mb-12">
                        <div class="breadcrumb-inner d-flex align-items-center justify-content-between">
                            <div class="breadcrumb-left">
                            </div>
                            <div class="breadcrumb-right"></div>
                        </div>
                    </div>
                    <!-- BREADCRUMB SECTION END -->
                    <!-- ATTRIBUTE WISE TABLE SECTION START -->
                    <div class="kpi-chips-section mb-24">
                        <h4 class="card-title">KPI Tags</h4>
                        <div class="kpi-chip-cont d-inline-flex flex-wrap">
                            <?php 
                            if(!empty($custom_kpi_details)){
                                foreach($custom_kpi_details as $each_custom_kpi_details){
                                    echo '<div class="kpi-chip">
                                        <input type="text" name="" placeholder="'. $each_custom_kpi_details->kpi_name.'" value="'. $each_custom_kpi_details->kpi_name.'" id="'.$each_custom_kpi_details->kpi_id.'" maxlength="10">
                                        <span class="chip_del"></span>
                                    </div>';
                                } 
                            } 
                            ?>
                            
                            <div class="kpi-chip-add">
                                <input type="text" name="" value="" maxlength="10" placeholder="New KPI">
                                <span class="kpi_add_btn"></span>
                            </div>
                        </div>
                    </div>
                    <div class="table-section mt-24">
                        <div class="kpi-form-choose d-flex flex-wrap align-items-center">
                            <label>Select Form</label>
                            <div class="kpi-input-field">
                                <select id="selected_form">
                                    <option value="">Select Form</option>
                                    <?php 
                                    if(!empty($template_details)){
                                        foreach($template_details as $each_template_details){
                                            echo '<option value="'.$each_template_details->tmp_unique_id.'">'.$each_template_details->tmp_name.'</option>';
                                        }
                                    } 
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-content .others_datatable_con">
                                <div class="card-header">
                                    
                                </div>
                                <table class="kpi_datatable" style="width:100%;" id="kpi_datatable">
                                    <thead>
                                        <tr>
                                            <th>Attribute Name</th>
                                            <th>Kpi Action </th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                                <div class="right-align kpi_submit_cont" style="display:none;">
                                    <button type="button" class="btn_kpi_final_submit btn cyan waves-effect waves-light">
                                        <span>Submit</span>
                                        <i class="material-icons right">send</i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ATTRIBUTE WISE TABLE SECTION END -->

                    <!-- TABLE SECTION END -->
                </div>
                <!-- MAIN CONTENTS END -->
            </main>
            <!-- MAIN SECTION END -->
            <!-- FOOTER SECTION START -->
            <?php $this->load->view('common/footer_view')  ?>
            <!-- FOOTER SECTION END -->
        </div>
        <!--JavaScript at end of body for optimized loading-->
        <?php $this->load->view('common/footer_file_view') ?>
        
    </body>
    <script type="text/javascript">
        function kpi_count_method(source, target){
            var data=[], count=0;
            source.each(function(){
                data.push($(this).find("input").val());
            })
            target.each(function(){
                var c_elem = $(this);
                c_elem.empty();
                $.each(data, function(key,value) {
                    c_elem.append('<option value="'+value+'">'+value+'</option>')
                })
            })
            //target.formSelect();
            $('.select_kpi_apply').formSelect();
            $('.kpi_datatable')
            .on('page.dt', function(){$('.kpi_datatable .select_kpi_apply').formSelect();})
            .on('order.dt', function(){$('.kpi_datatable .select_kpi_apply').formSelect();})
            .on('search.dt', function(){$('.kpi_datatable .select_kpi_apply').formSelect();})
            .DataTable();
        }
        $(document).on("blur", ".kpi-chip input", function(){
            if($(this).val() == "") {

                $(this).val($(this).attr('placeholder'));
                //$(this).closest(".kpi-chip").remove();
            }
            else{
                var kpi_name = $(this).val();
                var kpi_id = $(this).attr('id');
                // alert(kpi_id+'---'+kpi_name);
                var ajaxRes = postAjax('<?php echo site_url();?>/kpi-update',{'kpi_name':kpi_name,'kpi_id':kpi_id});
                if(ajaxRes == 'Success'){
                    $(this).val(kpi_name).attr('placeholder',kpi_name);
                    alertBox('KPI updated successfully');
                    //////RRRRRRRRRRRRRRRRRRRRRRRR
                    kpi_count_method($(".kpi-chip-cont .kpi-chip"), $(".kpi_datatable select"));
                }
                else{
                    alertBox('KPI not update try again ...');
                }
            }
        });
        $(document).on("click", ".chip_del", function(){
            var kpi_name = $(this).siblings('input').val();
            var kpi_id = $(this).siblings('input').attr('id');
           // alert(kpi_id+'---'+kpi_name);
             var ajaxRes = postAjax('<?php echo site_url();?>/kpi-delete',{'kpi_name':kpi_name,'kpi_id':kpi_id});
             if(ajaxRes == 'Success'){
                $(this).closest(".kpi-chip").remove();
                alertBox('KPI Deleted successfully');
                /// RRRRRRRRRRRRRRR
                kpi_count_method($(".kpi-chip-cont .kpi-chip"), $(".kpi_datatable select"));
             }
             else{
                alertBox('KPI not delete try again ...');
             }
            
        })

        $(document).on("click", ".kpi_add_btn", function(){
            if($('.kpi-chip').length < 8)
            {
                if($(this).hasClass("active")){
                    var kpi_name = $(this).siblings('input').val();
                    if(kpi_name != ''){
                        var ajaxRes = postAjax('<?php echo site_url();?>/kpi-insert',{'kpi_name':kpi_name});
                        //alert(ajaxRes);
                        if(ajaxRes != 'error'){
                            $(".kpi-chip-add").before('<div class="kpi-chip"><input type="text" name="" id="'+ajaxRes+'" value="'+ kpi_name+'" maxlength="10"><span class="chip_del"></span></div>');
                            $(this).siblings('input').val('');
                            alertBox('KPI added successfully');
                            ///////////////////////////RRRRRRRRRRRRRRR
                            kpi_count_method($(".kpi-chip-cont .kpi-chip"), $(".kpi_datatable select"));
                        }
                        $(this).removeClass("active").closest(".kpi-chip-add").removeClass("active");
                    }
                    else{
                        alertBox('please enter KPI name');
                    }
                    
                } else {
                    $(this).addClass("active").closest(".kpi-chip-add").addClass("active");
                }
            }
            else{
                alertBox('More then 8 KPI not allowed');
            }
        })
        // $('.kpi_datatable').DataTable(
        //     {
        //         "scrollX": true,
        //         columnDefs: [
        //             {  
        //                 orderable: false,
        //                 targets: [ 0, 2 ]
        //             }
        //         ],
        //         rowReorder: {
        //             selector: 'td:nth-child(2)'
        //         },
        //         responsive: true
        //     }
        // );
        $('#selected_form').change(function(){
           var tmp_unique_id = $(this).val();
           var ajaxRes = postAjax('<?php echo site_url();?>/attribute-list-kpi',{'tmp_unique_id':tmp_unique_id});
           //$('.rrr').html(JSON.stringify(ajaxRes.custom_kpi_details));
           $('.kpi_submit_cont').css('display','block');
           $('.kpi_datatable').dataTable({
                    "bDestroy": true,
                    responsive: true,
                    fixedHeader: true,
                    "bPaginate": false,
                    
                    
                    data:ajaxRes.attribute_details,
                    "columns": [                             
                        { 'data': 't_att_name'},                             
                        { 'defaultContent': 'hi'}                            
                    ],
                    columnDefs:[
                    {  
                        orderable: false,
                        targets: [ 1 ]
                    }, 
                    {
                        targets:[1],render:function(a,b,data,d)
                        {
                            
                            var select_html =  '<select  class="select_kpi_apply" multiple t_unique_id="'+data.t_unique_id+'"  t_att_id="'+data.t_att_id+'">';
                            $.each(ajaxRes.custom_kpi_details, function(key,value) {
                                select_html += '<option value="'+value.kpi_name+'">'+value.kpi_name+'</option>';
                            });   
                                select_html += '</select>';

                            return select_html;
                        }
                    }
                ]       
            });
            $('.select_kpi_apply').formSelect();
            $('.kpi_datatable')
            .on('page.dt', function(){$('.kpi_datatable .select_kpi_apply').formSelect();})
            .on('order.dt', function(){$('.kpi_datatable .select_kpi_apply').formSelect();})
            .on('search.dt', function(){$('.kpi_datatable .select_kpi_apply').formSelect();})
            .DataTable();

       });
       
        $(document).ready(function(){
            $(document).on("click",".btn_kpi_final_submit", function(){
            //$('.btn_kpi_final_submit').click(function(){
               // alert("PPPPPPPPPPPPPOOOOOOOOO");
               
                var final_data=[],  data='';
                $(".kpi-chip-cont .kpi-chip").each(function(){
                    data +=$(this).find("input").val() + '|';
                })
                final_data.push({
                    'all_kpi':data,
                    't_unique_id':$('.select_kpi_apply').attr('t_unique_id')
                })
                $(".select_kpi_apply").each(function(){
                    
                    var t_att_id = $(this).attr('t_att_id');
                    var selected_info = ($(this).val().join("|")) != ''?$(this).val().join("|"):null;
                    final_data.push({
                        
                        't_att_id':t_att_id,
                        't_kpi_val': selected_info,
                    })
                });
                // console.log(final_data);
                // $('.rrr').html(JSON.stringify(final_data));
                var ajaxRes = postAjax('<?php echo site_url();?>/kpi-save',{'kpi_data':final_data});
                 alertBox('KPI apply successfully');
                // if(ajaxRes == 'Success'){
                //     alertBox('KPI apply successfully');
                // }
                // else{
                //     alertBox('KPI not apply try again ...');
                // }
                //$('.rrr').html(JSON.stringify(ajaxRes));
            });
        });
    </script>
</html>