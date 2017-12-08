<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo getConfig('site_meta_description'); ?>">
    <meta name="author" content="<?php echo getConfig('site_meta_title'); ?>">

    <title><?php echo getConfig('site_name'); ?></title>
</head>

<body>
    <table style="box-shadow:0 0 4px #ddd; width:100%;margin:0 auto; max-width:450px; cell-spacing:0; cell-padding:0px; font-family: Roboto,sans-serif; background-color: #f0f4f5;">
        <tbody>
            <tr>
                <td style="text-align:center">
                    <a href="#"><img style=" margin:10px 0px; width:25%;" src="<?php echo base_url().getConfig('site_logo');?>"></a>
                </td>
            </tr>
            <tr>
                <td style="padding:0px;">
                    <table style=" margin:0 auto 5px; display:table; width:100%; color:#666; text-transform:capitalize;">
                        <tr>
<!--                            <td style="font-size:16px; width:105px; padding:2px 8px;  vertical-align:top;margin-bottom:20px;"></td>-->
                            <td style="font-size:12px; padding:2px 8px; color:#000; vertical-align:top;"><?php echo sprintf(lang('email_forgot_password_heading'), $identity);?></td>

                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding:0px;">
                    <table style="margin-bottom:10px; margin:0 auto 10px; display:table; width:100%; color:#666; text-transform:capitalize;">
                        <tr>
                            <td style="vertical-align:top; font-size:16px; display:table-cell; width:8px; padding:8px; font-weight: 900;">
                               <?php echo sprintf(lang('email_forgot_password_subheading'), anchor('admin/reset_password/'. $forgotten_password_code, lang('email_forgot_password_link')));?>
                            </td>

                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding:0px;">
                    <table style="margin-bottom:10px; margin:0 auto 10px; display:table; width:100%; color:#666; text-transform:capitalize;">
                        <tr>
                            <td colspan="2" style="vertical-align:top; width:162px; font-size:16px;display:table-cell; text-align:left; padding:8px 8px 8px 8px;">
                               Best Regards,
                            </td>
                       

                        </tr>
                        <tr>
                            <td colspan="2" style="vertical-align:top; width:162px; font-size:14px;display:table-cell; text-align:left; padding:8px 8px 8px 8px;">
                                <?php echo getConfig('site_name'); ?>
                            </td>
                        </tr>
                        <tr>
                        </tr>
                    </table>
            </tr>
        </tbody>
    </table>

</body>

</html>