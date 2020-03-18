<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Muli:300,400,600,700" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/materialize.min.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/theme.css"  media="screen,projection"/>
        <title>InsightsPRO</title>
    </head>
    <body>
        <div class="page-wrapper">
            <div class="user-forms">
            <?php
              if(validation_errors()){
                ?>
                <div class="alert alert-info text-center">
                  <?php echo validation_errors(); ?>
                </div>
                <?php
              }
    
            if($this->session->flashdata('message')){
              ?>
              <div class="alert alert-info text-center">
                <?php echo $this->session->flashdata('message'); ?>
              </div>
              <?php
            }	
            ?>
                <table class="table user-complete-register user-form-info" style="width:100%;">
                  <thead>
                    <tr>
                      <th>Client ID</th>
                      <th>Client Name</th>
                      <th>Client Email</th>
                      <th>Company </th>
                      <th>Phone No </th>
                      <th>Location </th>
                      <th>Plan </th>
                      <th>Active</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    foreach($users as $row){
                      ?>
                      <tr>
                        <td><?php echo $row->client_id; ?></td>
                        <td><?php echo $row->client_first_name .' '.$row->client_first_name; ?></td>
                        <td><?php echo $row->client_email; ?></td>
                        <td><?php echo $row->client_company; ?></td>
                        <td><?php echo $row->client_phone_no; ?></td>
                        <td><?php echo $row->client_location; ?></td>
                        <td><?php echo $row->client_plan; ?></td>
                        <td><?php echo $row->client_status ? 'True' : 'False'; ?></td>
                      </tr>
                      <?php
                    }
                  ?>
                  </tbody>
                </table>
            </div>
        </div>
        <!--JavaScript at end of body for optimized loading-->
        <script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/materialize.min.js"></script>
        <script>
            $(document).ready(function(){
                $('select').formSelect();
            });
        </script>
    </body>
</html>