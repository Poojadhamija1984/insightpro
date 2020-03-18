<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,600,700|Material+Icons">
        <link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/css/materialize.min.css" media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/css/jquery.dataTables.min.css" media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/css/buttons.dataTables.min.css" media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" media="all" />
        <link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/css/theme.css" media="screen,projection"/>
        <title>InsightsPRO</title>
        <script src="<?=base_url()?>assets/js/jquery-3.3.1.min.js"></script>
        <script>            
            $(window).on("load",function() {
                $(".page_loader").fadeOut("slow");
                $(".section_loader").fadeOut("slow");
                $("body").removeClass("content_loading");
            });
            BASEURL = '<?= site_url(); ?>';
        </script>
    </head>
