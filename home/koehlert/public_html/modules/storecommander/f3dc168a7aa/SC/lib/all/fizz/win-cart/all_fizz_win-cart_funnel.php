<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Store Commander</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="lib/css/style.css">
    <link rel="stylesheet" href="lib/all/fizz/win-cart/funnel.css">
    <script type="text/javascript" src="<?php echo SC_JQUERY;?>"></script>
    <style>
        body {
            line-height: 27px;
            font-weight: normal;
            font-family: Tahoma;
            font-size: 12px;
            color: #000000;
        }
    </style>
</head>
<body>
<center>

    <div class="demo-funnel" id="funnel"></div>

    <script type="application/javascript">
        var data = [];
        data = [{ label: '<?php echo _l('All e-Services'); ?>|all', value: 2000, backgroundColor: '#666666' },
            { label: '<?php echo _l('Acquisition'); ?>|acquisition', value: 12500, backgroundColor: '#960025' },
            { label: '<?php echo _l('Activation'); ?>|activation', value: 12500, backgroundColor: '#d70336' },
            { label: '<?php echo _l('Revenue'); ?>|revenue', value: 2500, backgroundColor: '#c8840d' },
            { label: '<?php echo _l('Retention'); ?>|retention', value: 2500, backgroundColor: '#6d953e' },
            /*{ label: '<?php echo _l('Recommendation'); ?>|recommendation', value: 2500, backgroundColor: '#008080' },*/
            { label: '<?php echo _l('Productivity'); ?>|productivity', value: 2500, backgroundColor: '#007fff' }];
    </script>
    <script type="text/javascript" src="lib/all/fizz/win-cart/funnel.js"></script>
</center>
</body>
</html>