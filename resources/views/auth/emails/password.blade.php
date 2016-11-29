<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]> <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]> <html class="ie8 oldie"> <![endif]-->
<!--[if IE 9]> <html class="ie9 oldie"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <title>Reestablecimiento de contraseña - {{env('APP_NAME')}}</title>
    </head>
    <body margin="0" style="margin:0">
        <table cellpadding="0" cellspacing="0" width="100%" border="0" bgcolor="#ffffff" style="background-color:#ffffff">
            <tbody>
                <tr>
                    <td width="134" height="81" rowspan="3" valign="top"><img src="http://unal.edu.co/fileadmin/templates/images/escudo_unal_mail_2.png" alt="escudo Universidad Nacional de Colombia" width="134" height="81"></td>
                    <td bgcolor="#94b43b" height="5" style="background-color:#94b43b;line-height:0"></td>
                </tr>
                <tr>
                    <td bgcolor="#444444" height="60">
                        <div style="float:right;text-align:right;margin-right:15px;color:#fff;font-size:14px;font-family:Georgia,serif;line-height:14px;max-height:60px;overflow:hidden">
                            Reestablecimiento de contraseña - {{env("APP_NAME")}}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td height="17">&nbsp;</td>
                </tr>
            </tbody>
        </table>
        <div>
            <br>
            <br>
            <p>Estimado aspirante:</p>
            <p>Por favor, de clic en el siguiente enlace para reiniciar su contraseña: <a target="_blank" href="<?php echo e(env('APP_URL')) . 'password/reset/' . $token; ?>">Reiniciar contraseña</a></p>
        </div>
    </body>
</html>
