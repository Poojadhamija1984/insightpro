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
                                <h3 class="page-title">Report</h3>
                                <ul class="breadcrumb-list">
                                    <li class="breadcrumb-item"><span>Audit Summary</span></li>
                                </ul>
                            </div>
                            <div class="breadcrumb-right"></div>
                        </div>
                    </div>
                    <!-- BREADCRUMB SECTION END -->
                    <!-- FORM SECTION START -->
                    
                    <?php 
                        $attributes = array("id" => "form col",'class'=>'formview');
                        echo form_open_multipart("",$attributes);
                    ?>  
                        <div class="form-section mt-24">
                            <div class="card">
                                <div class="card-content">
                                    <h4 class="card-title">Filters</h4>
                                    <div class="row mb-0">
                                        <!-- Start Date  -->
                                        <div class="input-field col s12 m4 l3">
                                            <input id="fromdate" name="fromdate" type="text" class="datepicker"  value="<?php if($fromdate) { echo $fromdate; } else { echo date('Y-m-d',strtotime(date('Y-m-01'))); } ?>">
                                            <label for="fromdate" class="">From</label>
                                        </div>
                                        <!-- End Date  -->
                                        <div class="input-field col s12 m4 l3">
                                            <input id="todate" name="todate" type="text" class="datepicker" value="<?php 
                                            if($todate) { echo $todate; }else{ echo date('Y-m-d'); }?>">
                                            <label for="todate" class="">To</label>
                                        </div>
                                       <!-- Site  -->
                                        <div class="input-field col s12 m4 l3">
                                            <select id="site" name="site[]"    multiple class="selectbox"> 
                                                <option value="" disabled>All</option>
                                                <?php
                                                foreach($sites as $key => $site_value){
                                                    if(in_array($site_value->s_id,$sitePost)){
                                                        $selected = 'selected';
                                                    } else {
                                                        $selected = '';
                                                    }        

                                                    echo "<option  ".$selected." value='{$site_value->s_id}'>{$site_value->s_name}</option>";
                                                }
                                                ?>
                                            </select>
                                            <label for="lob" class="">Site</label>
                                        </div>
                                     <!-- Template -->
                                        <div class="input-field col s12 m4 l3 md-mb-0">
                                            <select id="groups" name="groups[]" multiple class="selectbox"> 
                                                <option value="" disabled >All</option>
                                                <?php
                                                    foreach($groups as $key => $g_value){
                                                        if(in_array($g_value->g_id, $groupPost)){
                                                            $selected = 'selected';
                                                        } else {
                                                            $selected = '';
                                                        }
                                                        echo "<option ". $selected." value='{$g_value->g_id}'>{$g_value->g_name}</option>";
                                                    }
                                                ?>
                                            </select>
                                            <label for="groups" class="">Team</label>
                                        </div>

                                        <div class="input-field col s12 m4 l3 md-mb-0">
                                            <select id="tempaltes" name="tempaltes[]" multiple class="selectbox"> 
                                                <option value="" disabled >All</option>
                                                <?php
                                                foreach($tempaltes as $key => $g_value){
                                                   echo "<option value='{$g_value->tn}'>{$g_value->template_name}</option>";
                                                }
                                                ?>
                                            </select>
                                            <label for="groups" class="">Templates</label>
                                        </div>

                                        <div class="input-field col s12 m4 l3 md-mb-0">
                                            <select id="user" name="user[]" multiple class="selectbox"> 
                                                <option value="" disabled >All</option>
                                                <?php
                                                foreach($user as $key => $g_value){
                                                   echo "<option value='{$g_value->name}'>{$g_value->name}</option>";
                                                }
                                                ?>
                                            </select>
                                            <label for="groups" class="">Users </label>
                                        </div>
                                    
                                        <div class="input-field col s12 mb-0 form_btns">
                                            <button type="submit" id="submit" class="btn cyan waves-effect waves-light right">
                                                <span>Run Report</span>
                                                <i class="material-icons right">send</i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- FORM SECTION END -->

                    <!-- CARD SECTION START -->
                    <div class="col mt-24">
                        <div class="row mb-0">
                            <div class="col m4">
                                <div class="status-card card gradient-45deg-purple-deep-orange">
                                    <h5 class="stats-heading">Total Audit Conducted</h5>
                                    <span class="total_count stats-count">
                                        <?php 
                                            echo ((!empty($total_audit))?$total_audit:0);
                                        ?>
                                    </span>                                            
                                </div>
                            </div>
                            <div class="col m4">
                                <div class="status-card card gradient-45deg-purple-deep-orange">
                                    <h5 class="stats-heading">Average Score</h5>
                                    <span class="total_avg stats-count">
                                        <?php
                                            echo (!empty($avg)?$avg."%":"0%");
                                        ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col m4">
                                <div class="status-card card gradient-45deg-purple-deep-orange">
                                    <h5 class="stats-heading">Failed Percentage </h5>
                                    <span class="total_failed stats-count">
                                        <?php
                                            echo (!empty($failed_avg)?$failed_avg."%":"0%");
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- CARD SECTION END -->
                  
                    <!-- TABLE SECTION START -->
                        <div class="table-section mt-24">
                            <div class="card">
                                <div class="card-content">
                        	       <table class="stripe hover data_table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Template Name</th>
                                                <th>Site</th>
                                                <th>Total Score(%)</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                foreach ($content as $key => $value) {
                                                    $url = site_url()."/template/$value->tmp_unique_id/view/$value->audit_id";
                                                    echo "<tr>
                                                            <td><a href= '$url' target='_blank'>$value->audit_id</a></td>
                                                            <td>$value->auditor_name</td>
                                                            <td>$value->template_name</td>
                                                            <td>$value->audit_sites</td>
                                                            <td>".(!empty($value->faild_per)?$value->faild_per:0)."%</td>
                                                            <td>$value->audit_date</td>
                                                        </tr>";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
</html>

<script>
    selectedTemplate();
    function selectedTemplate(){
        var temp = '<?php echo json_encode(!empty($postTemplates)?$postTemplates:[]);?>';
        kpiRetention     =   JSON.parse(temp);
        if(kpiRetention.length > 0){
            $.each(kpiRetention, function(key2,val2){
                $('#tempaltes option[value="'+val2+'"]').attr("selected", "selected");
            });
        }
        //console.log('temp',kpiRetention);
    }
    selectedusers();
    function selectedusers(){
        var temp = '<?php echo json_encode(!empty($users)?$users:[]);?>';
        kpiRetention     =   JSON.parse(temp);
        if(kpiRetention.length > 0){
            $.each(kpiRetention, function(key2,val2){
                $('#user option[value="'+val2+'"]').attr("selected", "selected");
            });
        }
        //console.log('temp',kpiRetention);
    }
</script> 