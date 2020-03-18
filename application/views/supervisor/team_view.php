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
            <?php 
                if($this->session->flashdata('permission_denied')){
                    $this->load->view('url_access');    
                }
                else{
            ?>
            <main>
                <!-- BREADCRUMB SECTION START -->
                <div class="breadcrumb-section p-24">
                    <div class="breadcrumb-inner d-flex align-items-center justify-content-between">
                        <div class="breadcrumb-left">
                            <h3 class="page-title">Team View</h3>
                        </div>
                        <div class="breadcrumb-right"></div>
                    </div>
                </div>
                <!-- BREADCRUMB SECTION END -->

                <!-- FORM SECTION START -->
                <div class="form-section px-24 mb-24">
                    <div class="card">
                        <div class="card-content">
                            <h4 class="card-title">Filters</h4>
                            <form class="form col">
                                <div class="row mb-0">
                                    <div class="input-field col s12 l4 xl3">
                                        <input id="audit_from_date" type="text" class="datepicker" value="<?php echo date('Y-m-d',(strtotime ( '-30 day' , strtotime ( date('Y-m-d')) ) ));?>">
                                        <label for="audit_from_date" class="">From</label>
                                    </div>
                                    <div class="input-field col s12 l4 xl3">
                                        <input id="audit_to_date" type="text" class="datepicker" value="<?php echo date('Y-m-d',strtotime('+1 day', strtotime(date('Y-m-d'))));?>">
                                        <label for="audit_to_date" class="">To</label>
                                    </div>
                                    <div class="input-field col s12 l4 xl3">
                                        <select id="audit_lob" >
                                            <option value="" disabled selected>Select</option>
                                            <?php 
                                                $lob = explode('|||', $this->session->userdata('lob'));
                                                foreach ($lob as $key => $value) {
                                                    echo "<option value='{$value}'>{$value}</option>";
                                                }
                                            ?>
                                                
                                        </select>
                                        <label for="audit_lob" class="">Lob</label>
                                    </div>
                                    <div class="input-field col s12 l4 xl3 mb-0 form_btns">
                                        <button type="submit" class="btn cyan waves-effect waves-light right" id="audit_filter">
                                            <span>Run Report</span>
                                            <i class="material-icons right">send</i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <div class="table-section mt-24">
                                <table class="csv_table stripe hover" id="auditData" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>User ID</th>
                                            <th>Name</th>
                                            <th>Lob</th>
                                            <th>Audit Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            if(!empty($emp_data)){
                                        	   foreach ($emp_data as $key => $value) {
                                        		  echo "<tr emp_id='{$value->empid}' lob='".implode(',',(explode('|||', $value->lob)))."' to_date={$value->to_date} from_date = {$value->form_date}>
                                        					<td>{$value->empid}</td>
                                        					<td>{$value->name}</td>
                                        					<td>".implode(',',(explode('|||', $value->lob)))."</td>
                                        					<td class='emp_audit_history'>".$emp_audit_count[$value->empid]."</td>
                                        				</tr>";
                                        	   }
                                            }
                                            else{
                                                echo "<tr><td clospan='4' style='text-align:center'>No Data found</td></tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FORM SECTION END -->

                <!-- TABLE SECTION START -->
                <div class="table-section px-24 my-24">
                    <div class="card">
                        <div class="card-content">
                            <h4 class="card-title">List of Audits by <span id="aeid"></span> between <span id="dd"></span></h4>
                            <table class="data_table stripe hover" id="emp_audit_data" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Unique ID</th>
                                        <th>Lob</th>
                                        <th>Call ID</th>
                                        <th>Agent</th>
                                        <th>Form Name</th>
                                        <th>form_version</th>
                                        <th>issue_type</th>
                                        <th >total_score</th>
                                        <th >Calibration</th>
                                        <th >ATA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- TABLE SECTION END -->
            </main>
            <?php } ?>
            <!-- MAIN SECTION END -->
            <!-- FOOTER SECTION START -->
            <?php $this->load->view('common/footer_view')  ?>
            <!-- FOOTER SECTION END -->
        </div>
        <!--JavaScript at end of body for optimized loading-->
        <?php $this->load->view('common/footer_file_view') ?>
       </body>
</html>

        <script type="text/javascript">
            $(function(){
                $(document).delegate('.emp_audit_history','click',function(){
                    var tr = $(this).closest("tr");
                    var  emp_id     = tr.attr('emp_id');
                    var  lob        = tr.attr('lob');
                    var  to_date    = tr.attr('to_date');
                    var  from_date  = tr.attr('from_date');
                    var base_url    = "<?php echo site_url();?>/emp-all-audit-data";
                    var response    = postAjax(base_url,{'emp_id':emp_id,'lob':lob,'to_date':to_date,'from_date':from_date});
                    $('#emp_audit_data').DataTable().clear().draw();
                    console.log(response);
                    var audit_data = response.audit_data;
                    var singleArray = [];
                    for (i=0; i<audit_data.length; i++) { 
                        for (x=0; x<audit_data[i].length; x++) {
                            var dd = {};
                            var a  = "<?php echo site_url();?>/form-view/"+audit_data[i][x].form_name+"/"+audit_data[i][x].form_version+"/"+response.url+"/"+audit_data[i][x].unique_id;
                            //var calli = "<?php echo site_url();?>/form-view/"+audit_data[i][x].form_name+"/"+audit_data[i][x].form_version+"/callibrate/"+audit_data[i][x].unique_id;
                            //var ata = "<?php echo site_url();?>/form-view/"+audit_data[i][x].form_name+"/"+audit_data[i][x].form_version+"/ata/"+audit_data[i][x].unique_id;
                            dd.unique_id     =  '<a href="'+a+'">'+audit_data[i][x].unique_id+'</a>';
                            dd.lob           =  audit_data[i][x].lob;
                            dd.call_id       =  audit_data[i][x].call_id;
                            dd.agent_id      =  audit_data[i][x].agent_id;
                            dd.form_name     =  audit_data[i][x].form_name;
                            dd.form_version  =  audit_data[i][x].form_version;
                            dd.issue_type    =  audit_data[i][x].issue_type;
                            dd.total_score   =  audit_data[i][x].total_score;
                           // dd.callibrate    =  '<a href="'+calli+'">'+audit_data[i][x].callibrate+'</a>';
                            //dd.ata           =  '<a href="'+ata+'">'+audit_data[i][x].ata+'</a>';
                            dd.callibrate    =  audit_data[i][x].callibrate;
                            dd.ata           =  audit_data[i][x].ata;
                            singleArray.push(dd);  
                        };
                    };
                     console.log(singleArray);
                    $('#aeid').html(emp_id);
                    $('#dd').html(response.between);
                    $('#emp_audit_data tbody').html('');
                    $('#emp_audit_data').dataTable({
                        "bDestroy": true,
                        responsive: true,
                        fixedHeader: true,
                        scrollX : true,
                        // scrollY : '30vh',
                        data:singleArray,
                        "columns": [
                            { 'data': 'unique_id' } ,
                            { 'data': 'lob' },
                            { 'data': 'call_id' },
                            { 'data': 'agent_id' },
                            { 'data': 'form_name' },
                            { 'data': 'form_version' },
                            { 'data': 'issue_type' },
                            { 'data': 'total_score' },
                            { 'data': 'callibrate' },                               
                            { 'data': 'ata' }                               
                        ]
                    });
                    //var table = $('#emp_audit_data').DataTable({"destroy": true});
                   /* $.each(response.audit_data,function(key,val){
                        $.each(val,function(key1,val1){
                            var unique_id       = val1.unique_id;
                            var total_score     = val1.total_score;
                            var lob             = val1.lob;
                            var call_id         = val1.call_id;
                            var agent_id        = val1.agent_id;
                            var agent_name      = val1.agent_name;
                            var issue_type      = val1.issue_type;
                            var form_version    = val1.form_version;
                            var form_name       = val1.form_name;
                            var url             = response.url;
                            var callibrate      = val1.callibrate;
                            var atad             = val1.ata;

                            var a = "<?php echo site_url();?>/form-view/"+form_name+"/"+form_version+"/"+url+"/"+unique_id;
                            var calli = "<?php echo site_url();?>/form-view/"+form_name+"/"+form_version+"/callibrate/"+unique_id;
                            var ata = "<?php echo site_url();?>/form-view/"+form_name+"/"+form_version+"/ata/"+unique_id;
                            $('#emp_audit_data tbody').append("<tr><td> <a target='_blank' href="+a+">"+unique_id+"</a></td><td>"+lob+"</td><td>"+call_id+"</td><td>"+agent_name+"</td><td>"+form_version+"</td><td>"+form_name+"</td><td>"+issue_type+"</td><td>"+total_score+"</td><td><a target='_blank' href="+calli+">"+callibrate+"</a><td><a target='_blank' href="+ata+">"+atad+"</a></td></tr>");
                        });
                    });*/
                    //setTimeout(function(){ table.invalidate().draw(); }, 3000);
                });
                $('#audit_filter').click(function(e){
                    e.preventDefault();
                    var audit_from_date =   $('#audit_from_date').val();
                    var audit_to_date   =   $('#audit_to_date').val();
                    var audit_lob       =   $('#audit_lob').val();
                    var base_url        =   "<?php echo site_url();?>/emp-all-audit-data";
                    if(audit_from_date == '' || audit_to_date == '' || audit_lob == null){
                        alert('All fields are mandatory');
                        return false;
                    }
                    else{
                        var response        =   postAjax(base_url,{'lob':audit_lob,'to_date':audit_to_date,'from_date':audit_from_date,'filter':true});
                        console.log(response);
                        $('#auditData tbody').html('');
                        $('#auditData').dataTable({
                                "bDestroy": true,
                                responsive: true,
                                fixedHeader: true,
                                scrollX : true,
                                // scrollY : '30vh',
                                data:response.emp_data,
                                "columns": [
                                    { 'data': 'empid' } ,
                                    { 'data': 'name' },
                                    { 'data': 'lob' },
                                    { 'data': 'emp_audit_count' }                
                                ],
                                'createdRow': function( row, data, dataIndex ) {
                                    console.log('dataIndex',row)
                                    $(row.childNodes[3]).addClass('emp_audit_history')
                                    $(row).attr('emp_id',data.empid);
                                    $(row).attr('lob',urldecode(data.lob));
                                    $(row).attr('to_date',data.to_date);
                                    $(row).attr('from_date',data.form_date);
                                },
                                columnDefs:[{
                                targets:[2],render:function(a,b,data,d)
                                {
                                    return urldecode(data.lob);
                                }
                            }]
                            });
                        //var table = $('#auditData').DataTable({"destroy": true});
                        // $.each(response.emp_data,function(key,val){
                        //     var empid           = val.empid;
                        //     var name            = val.name;
                        //     var lob             = urldecode(val.lob);
                        //     var emp_audit_count = val.emp_audit_count;
                        //     var form_date       = val.form_date;
                        //     var to_date         = val.to_date;
                            

                        //     $('#auditData tbody').append("<tr emp_id="+empid+" lob="+val.lob+" to_date="+to_date+" from_date="+form_date+"><td>"+empid+"</td><td>"+name+"</td><td>"+lob+"</td><a href='#'><td class='emp_audit_history'>"+emp_audit_count+"</a></td></tr>");
                        // });
                    }
                });
                function urldecode(str) {
                    return decodeURIComponent((str+'').replace(/\+/g, '%20'));
                }
            });
        </script>
    