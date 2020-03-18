<div class="filter-section">
    
        <h4 class="filter_heading">Filter Data</h4>
        <div class="col filter_inner">
            <div class="row mb-0">
            <div class="col s6 m4 xl3">
                    <div class="input-field custom-input--field">
                    <select id="date_range1" name="date_range" onchange="dependentData('date_range1')">
                                    <option value="Daily" selected>Daily</option>
                                    <option value="Weekly">Weekly</option>
                                    <option value="Monthly">Monthly</option>
                                </select>
                    </div>
                </div>
                <div class="col s6 m4 xl3 filter_other">
                    <div class="input-field custom-input--field">
                    <select id="date_range" name="date_range">
                                </select>
                    </div>
                </div>
                <div class="col s6 m4 xl3 s_date_c">
                    <div class="input-field custom-input--field">
                        <input type="text" name="s_date" id="s_date" class="datepicker" placeholder="Choose From" value="<?php echo date('Y-m-d');?>">
                        <label for="s_date">From</label>
                    </div>
                </div>
                <div class="col s6 m4 xl3 t_date_c">
                    <div class="input-field custom-input--field">
                        <input id="e_date" type="text" name="e_date" class="datepicker" placeholder="Choose To" value="<?php echo date('Y-m-d');?>">
                        <label for="e_date">To</label>
                    </div>
                </div>
                <div class="col s6 m4 xl3">
                    <div class="input-field custom-input--field">
                        <select id="sites" sites[] multiple class="selectbox">
                            <option value="" disabled>Select Sites</option>
                            <?php 
                                foreach ($sites as $key => $value) {
                                    $opt_val = $value['s_id'];
                                    $opt_name = $value['s_name'];
                                    echo "<option value='".$opt_val."'>".$opt_name."</option>";
                                }
                            ?>
                        </select>
                        <label for="sites">Sites</label>
                    </div>
                </div>
                <div class="col s6 m4 xl3">
                    <div class="input-field custom-input--field">
                        <select id="groups" name="groups[]" multiple class="selectbox">
                            <option value="" disabled>Select Groups</option>
                            <?php 
                                foreach ($groups as $key => $value) {
                                    $opt_val = $value['g_id'];
                                    $opt_name = $value['g_name'];
                                    echo "<option value='".$opt_val."'>".$opt_name."</option>";
                                }
                            ?>
                        </select>
                        <label for="groups">Groups</label>
                    </div>
                </div>
                <div class="col s6 m4 xl3">
                    <div class="input-field custom-input--field">
                        <select id="templates"class="">
                            <option value="" disabled>Select Forms</option>
                            <?php 
                                foreach ($templates as $key => $value) {
                                    $btableName = str_replace('tb_temp_','',$value->tb_name);
                                    echo "<option value='$value->tb_name'>$value->tmp_name</option>";
                                }
                            ?>
                        </select>
                        <label for="templates">Templates</label>
                    </div>
                </div>
                <div class="col s1 m1">
                    <button type="javascript:void(0)" class="filter_submit" onclick="onchangeReviewer()"><i class="material-icons" style="line-height: inherit;display: block;cursor:pointer">search</i></button>
                </div>
            </div>
        </div>
   
</div>
<!-- Filter Code End -->
<?php  
    //$attributes = array('id' => 'datefilterFrm', 'class' => 'col');
    //echo form_open_multipart('dashboard',$attributes);
?>
<!--<ul class="collapsible">
    <li>
        <div class="collapsible-header"><i class="material-icons">search</i>Filter</div>
        <div class="collapsible-body">
            <div class="row">
                <div class="input-field col s2">
                    <input id="s_date" type="text" class="datepicker validate">
                    <label for="s_date">Start Date</label>
                </div>
                <div class="input-field col s2">
                    <input id="e_date" type="text" class="datepicker validate">
                    <label for="e_date">End Date</label>
                </div>
                <div class="input-field col s3">
                    <select multiple id="sites">
                        <option value="" disabled>Select Sites</option>
                        <?php 
                            foreach ($sites as $key => $value) {
                                echo "<option value='".$value['s_id']."'>".$value['s_name']."</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="input-field col s3">
                    <select multiple id="groups">
                        <option value="" disabled>Select Groups</option>
                        <?php 
                            foreach ($groups as $key => $value) {
                                echo "<option value='".$value['g_id']."'>".$value['g_name']."</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="input-field col s3">
                    <select multiple id="templates">
                        <option value="" disabled>Select Templates</option>
                        <?php 
                            foreach ($templates as $key => $value) {
                                echo "<option value='$value->tb_name'>$value->tmp_name</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </li>
</ul>-->
<?php //echo form_close();?>
<script type="text/javascript">
    var bcrumb_top = $("header").outerHeight();
    $(window).on("scroll",function(){
        if($(window).scrollTop() > 15) {
            $(".breadcrumb-section").addClass("sticky");
        }
        else {$(".breadcrumb-section").removeClass("sticky");}
    });
    $(document).ready(function(){
        $(".filter_btn").on("click", function(){
            $(this).toggleClass("active");
            $(".filter_form").slideToggle("fast");
        })
        if($(window).scrollTop() > bcrumb_top) {
            $(".breadcrumb-section").addClass("sticky");
        }
        var base_url = '<?php echo site_url();?>/';
        $('.collapsible').collapsible();
        var groupsArr   = [];
        var sitesArr    = [];
        $('#sites').change(function(){
            sitesArr = $(this).val();
            data = {'sites':sitesArr,'groups':groupsArr}
            var response = postAjax_With_Loder(base_url+'template-data',data);
            modifyTemplate('templates','Templates',response);
            var groupresponse = postAjax_With_Loder(base_url+'get-group-data',{'sites':sitesArr,'filter':true});
            modifyTemplate('groups','Groups',groupresponse);
        });
        $('#groups').change(function(){
            groupsArr = $(this).val();
            console.log(sitesArr);
            console.log(groupsArr);
            data = {'sites':sitesArr,'groups':groupsArr}
            var response = postAjax_With_Loder(base_url+'template-data',data);
            modifyTemplate('templates','Templates',response)
        });
    });

    function modifyTemplate(divId,select,response){
        $('#'+divId).empty();
        $('#'+divId).append($("<option value='' disabled>Select "+select+"</option>"));
        $.each(response, function( key, val ) {

            $('#'+divId).append($("<option></option>").attr("value",val.value).text(val.name)).formSelect();
        });
    }
</script>
<script>
 $(document).ready(function(){
            $('.filter_other').removeClass('show').addClass('hide');
            $('.s_date_c').removeClass('hide').addClass('show');
            $('.t_date_c').removeClass('hide').addClass('show');
           });
           function dependentData(id)
                {
            var textVal = $('#'+id).val();
            var depTimeFilter ={};
            $("#date_range").empty();
            if(textVal=='Daily')
            {
                $('.filter_other').removeClass('show').addClass('hide');
                $('.s_date_c').removeClass('hide').addClass('show');
                 $('.t_date_c').removeClass('hide').addClass('show');
                depTimeFilter ={"Today":"Today","Custom":"Custom Date"};
                location.reload(true);
                   
            }else{
                $('.filter_other').removeClass('hide').addClass('show');
                $('.s_date_c').removeClass('show').addClass('hide');
                $('.t_date_c').removeClass('show').addClass('hide');
            }
            var html ="";
            
            if(textVal=='Weekly')
            {
                depTimeFilter ={'':'Select Week' ,"1_Weeks":"1 Week","3_Weeks":"3 Weeks","4_Weeks":"4 Weeks"};
            }else if(textVal=='Monthly')
            {
                depTimeFilter ={'':'Select Month',"1_Months":"1 Month","3_Months":"3 Months","6_Months":"6 Months","12_Months":"12 Months"};
            }else if(textVal=='Yearly')
            {
                depTimeFilter ={"1Year":"1 Year","3Year":"3 Year","6Year":"6 Year"}; 
            }
            for(var key in depTimeFilter)
            {
            html += "<option value='"+key+"'>"+depTimeFilter[key]+"</option>";
            }
            
            $("#date_range").append(html).formSelect();
           
        }
</script>