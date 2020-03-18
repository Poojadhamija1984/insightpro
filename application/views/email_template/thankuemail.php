<html>
	<head>
		<title>Account Created Successfully</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<link href="https://fonts.googleapis.com/css?family=Muli:300,400,600,700" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,800" rel="stylesheet">
	</head>
	<body>
		<table style="border-collapse: collapse;width: 75%;max-width:600px;margin: 40px auto;font-weight:400;font-family: Montserrat, sans-serif;border: 1px solid #dcdcdc;">
            <thead>
                <tr>
                    <th style="padding:20px 30px 0;text-align: center;text-transform: capitalize;font-size:20px;font-weight:600;font-family: Muli, sans-serif;color: #8e24aa;line-height: 1;"><span style="display:inline-block;vertical-align: middle;">Insights</span><strong style="display:inline-block;vertical-align: middle;font-weight:800;color:rgb(255, 255, 255);background-color: #ff6e40;padding:3px 5px; border-radius: 5px;">Pro</strong></th>
                </tr>
                <tr>
                    <th style="padding:20px 30px 6px;text-align: center;text-transform: capitalize;font-size:20px;font-weight:800;color: #2E7D32;">Thank You, <?php echo $client_first_name;?></th>
                </tr>
                <tr>
                    <th style="padding:0 30px 20px;text-align: center;font-size:14px;font-weight:600;color: #565656;">Start exploring the tool by following the below mentioned link. </th>
                </tr>
            </thead>
            <tbody>
                
                <tr>
                    <td style="padding:20px 30px 15px;text-align: center;line-height: 1.6;font-size: 13px;font-weight:500;color: #565656;">Please bookmark your Account link to login in future .</td>
                </tr>
                <tr>
                    <td style="padding:0 30px 20px;text-align: center;font-size: 14px;color:rgb(255, 255, 255);font-weight:600;"><a href="<?php echo $client_id;?>"><?php echo $client_id;?></a></td>
                </tr>
                <tr>
                    <td style="background-color:#efefef;">
                        <table style="width:100%;border-collapse: collapse;">
                            <tbody>
                                <tr>
                                    <td style="padding:20px 30px 0;text-align: center;font-size: 12px;font-weight:600;line-height: 1.6;">Need help? Check out our quick User Guide for answers to common questions.</td>
                                </tr>
                                <tr>
                                    <td style="padding:15px 30px;text-align: center;font-size: 12px;font-weight:500;color: #676767;line-height: 1.6;">Get in touch with one of our experts, you can reach us at <a href="mailto:support@insightspro.io" style="text-decoration: underline;color:#333;">support@insightspro.io</a> or visit our Online Support Center anytime, day or night, to resolve your query.</td>
                                </tr>
                                <tr>
                                    <td style="padding:0 30px 15px;text-align: center;font-size: 12px;font-weight:500;color: #ff6e40;">This is an automatically generated email, please do not reply</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="background-color: #000;padding:30px;">
                        <table style="border-collapse: collapse;width:100%;">
                            <tbody>
                                <tr>
                                    <td style="padding-bottom: 5px;font-weight: 600;font-size: 12px;color: rgb(255, 255, 255);text-align: center;text-transform: capitalize;">Our mailing address</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:400;font-size:12px;color:rgb(255, 255, 255);text-align:center;">576 Glatt Circle, Woodburn, OR, Zip - 97071, USA</td>
                                </tr>
                                <tr>
                                    <td style="padding:20px 30px 0;text-align: center;">
                                        <img src="<?php echo base_url();?>assets/images/facebook.png" alt="facebook" style="border-radius:50%;width:32px;height:32px;line-height:32px;text-align:center;display:inline-block;vertical-align: middle;text-decoration:none; margin-right:3px;" />
                                        <img src="<?php echo base_url();?>assets/images/twitter.png" alt="twitter" style="border-radius:50%;width:32px;height:32px;line-height:32px;text-align:center;display:inline-block;vertical-align: middle;text-decoration:none; margin-right:3px;" />
                                        <img src="<?php echo base_url();?>assets/images/kalbos.png" alt="kalbos" style="border-radius:50%;width:32px;height:32px;line-height:32px;text-align:center;display:inline-block;vertical-align: middle;text-decoration:none;" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding:12px 30px;text-align:center;font-size: 11px;color:rgb(255, 255, 255);background-color: #232323;">Copyright &copy; 2019, MattsenKumar LLC, All rights reserved.</td>
                </tr>
            </tbody>
		</table>
	</body>
</html>