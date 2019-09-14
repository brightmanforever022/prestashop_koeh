
$(document).ready(function() {
    $('#sticker_print_dymo').click(function() {
        PrintLabels();
    });

    $('#sticker_exhb_print_dymo').click(function(){
    	DymoLabelExhbPrint();
    });

    $('#sticker_print_pdf,#sticker_exhb_print_pdf,#prodimg_pdf').click(function() {
    	$('#form-product').attr('target', '_blank');
    	return;
    });
    $('#sticker_print_pdf,#sticker_exhb_print_pdf,#prodimg_pdf').blur(function(){
    	$('#form-product').attr('target', '_self');
    });

    function startupCode() {

    }
    function frameworkInitShim() {
        dymo.label.framework.init(startupCode);
    }
    window.onload = frameworkInitShim;
})

function DymoLabelExhbPrint()
{
	var count = $('input[name="productBox[]"]:checked').length;
	
    if(count < 1) {
        alert('No products are selected');
        throw new Error('No products are selected');
    }
	
    let stickersData = [];
    $('input[name="productBox[]"]:checked').each(function(key, item){
    	let prodId = parseInt($(this).val());
    	let parentTr = $(this).parents('tr');
    	
    	let productBaseSplRef = $(parentTr).find('.base_prod_spl_ref').text().trim();
    	if( productBaseSplRef == null ){
    		return;
    	}
    	
    	let productRefCode = productBaseSplRef.match(/^(\d{4})/);
    	if( !Array.isArray(productRefCode) || (productRefCode[1] == null) ){
    		return;
    	}
    	productRefCode = productRefCode[1];
    	
    	let productRefCodeExist = stickersData.find(function(element){
    		return element.code == productRefCode;
    	});
    	
    	let sizesStockTable = $(parentTr).find('.product_sizes_stock');
    	if( !$(sizesStockTable).length ){
    		return;
    	}
    	let prodPrice = parseFloat( $(sizesStockTable).data('price') );
    	
    	if( (productRefCodeExist == null) && Array.isArray(variantColors[productRefCode]) && !isNaN(prodPrice) ){
    		stickersData.push({
    			code: productRefCode,
    			colors: variantColors[productRefCode],
    			price: prodPrice
    		});
    	}
    });
    
    //console.log(stickersData);
    
    if( !stickersData.length ){
        alert('No products parsed for printing');
        throw new Error('No products are selected');
    }
    
    var printers = dymo.label.framework.getPrinters();
    if (printers.length == 0) {
        alert("No DYMO printers are installed. Install DYMO printers.");
        throw "No DYMO printers are installed. Install DYMO printers.";
    }


    var printerName = "";
    for (var i = 0; i < printers.length; ++i)
    {
        var printer = printers[i];
        if (printer.printerType == "LabelWriterPrinter")
        {
            printerName = printer.name;
            break;
        }
    }

    if (printerName == "") {
        alert("No LabelWriter printers found. Install LabelWriter printer");
        throw "No LabelWriter printers found. Install LabelWriter printer";
    }
    
    function getLabelQrCode(stickerInd){
    	if(stickersData[stickerInd] == null){
    		return;
    	}
    	$.ajax({
    		url: '../modules/qrcode/generate.php?text='+ encodeURI(stickersData[stickerInd].code)
    			+ '&output=base64&size=3', 
    		method: 'GET',
    		success: function(response, status, jqXHR){
    			stickersData[stickerInd].qr_code_image_base64 = response;
    			getLabelQrCode(++stickerInd);
    		}
    	});
    };
    
    getLabelQrCode(0);
    
    //console.log(stickersData);
    
    $(stickersData).each(function(key, item){
    	
    	let reference_code = this.code;
    	let reference_colors = this.colors.join(`\n`);
    	let price = this.price;
    	let labelXml = dymoLabelExhbTempl(this.code, this.colors.join(`\n`), this.price, this.qr_code_image_base64);// dymoLabelExhbTempl;
    	
    	try{
            var label = dymo.label.framework.openLabelXml(labelXml);
            // create label set to print data
            var labelSetBuilder = new dymo.label.framework.LabelSetBuilder();

            // first label
            var record = labelSetBuilder.addRecord();
            record.setText("Text", this.code);

            // create label set to print data
            //var labelk = dbk_name + '<br>' + sup_refference + '<br>' + size + '<br>' + price;

            label.print(printerName);
    	}
    	catch(e){
    		alert(e.message || e);
    	}
    });
}

    // called when the document completly loaded
    function PrintLabels()
    {

        var count = $('input[name="productBox[]"]:checked').length;

        if(count < 1) {
            alert('No products are selected');
            throw new Error('No products are selected');
        }
        
        let stickersData = [];
        $('input[name="productBox[]"]:checked').each(function(key, item){
        	let prodId = parseInt($(this).val());
        	let parentTr = $(this).parents('tr');
        	
        	let sizesStockTable = $(parentTr).find('.product_sizes_stock');
        	if( !$(sizesStockTable).length ){
        		return;
        	}
        	let prodWholesalePrice = $(sizesStockTable).data('price');
        	$(sizesStockTable).find('th').each(function(key, item){
        		let splRef = $(this).data('spl_ref');
        		if( (splRef === undefined) || (splRef == null) || !splRef.length ){
        			return;
        		}
        		splRef = $.trim(splRef);
        		
                let splRefParts = splRef.split('_');
                stickersData.push({
                	code : splRefParts[0] ? splRefParts[0] : '',
                	size : splRefParts[2] ? splRefParts[2] : '',
                	color : splRefParts[1] ? splRefParts[1] : '',
                	price : prodWholesalePrice
                });
        	});
        });
        
        if( !stickersData.length ){
            alert('No products parsed for printing');
            throw new Error('No products are selected');
        }
        
//
        // select printer to print on
        // for simplicity sake just use the first LabelWriter printer
        var printers = dymo.label.framework.getPrinters();
        if (printers.length == 0) {
            alert("No DYMO printers are installed. Install DYMO printers.");
            throw "No DYMO printers are installed. Install DYMO printers.";
        }


        var printerName = "";
        for (var i = 0; i < printers.length; ++i)
        {
            var printer = printers[i];
            if (printer.printerType == "LabelWriterPrinter")
            {
                printerName = printer.name;
                break;
            }
        }

        if (printerName == "") {
            alert("No LabelWriter printers found. Install LabelWriter printer");
            throw "No LabelWriter printers found. Install LabelWriter printer";
        }

        // finally print the label
        var success = false;
        
        $(stickersData).each(function(key, item) {
            var sup_refference = this.code;
            var size = this.size;
            var dbk_name = this.color;
            var price = this.price;

            try
            {
                // open label
                var labelXml = '<?xml version="1.0" encoding="utf-8"?>\
                    <DieCutLabel Version="8.0" Units="twips">\
                <PaperOrientation>Portrait</PaperOrientation>\
                <Id>WhiteNameBadge11356</Id>\
                <IsOutlined>false</IsOutlined>\
                <PaperName>11356 White Name Badge - virtual</PaperName>\
            <DrawCommands>\
            <RoundRectangle X="0" Y="0" Width="2340" Height="5040" Rx="270" Ry="270" />\
                </DrawCommands>\
                <ObjectInfo>\
                <TextObject>\
                <Name>TEXT_3</Name>\
                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                <LinkedObjectName />\
                <Rotation>Rotation0</Rotation>\
                <IsMirrored>False</IsMirrored>\
                <IsVariable>False</IsVariable>\
                <GroupID>-1</GroupID>\
                <IsOutlined>False</IsOutlined>\
                <HorizontalAlignment>Left</HorizontalAlignment>\
                <VerticalAlignment>Bottom</VerticalAlignment>\
                <TextFitMode>None</TextFitMode>\
                <UseFullFontHeight>True</UseFullFontHeight>\
                <Verticalized>False</Verticalized>\
                <StyledText>\
                <Element>\
                <String xml:space="preserve">Artikelnr. / Style:</String>\
            <Attributes>\
            <Font Family="Arial" Size="12" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" HueScale="100" />\
                </Attributes>\
                </Element>\
                </StyledText>\
                </TextObject>\
                <Bounds X="88.1514892578125" Y="331.200012207031" Width="2196.64846038818" Height="284.571441650391" />\
                </ObjectInfo>\
                <ObjectInfo>\
                <BarcodeObject>\
                <Name>-BARCODE</Name>\
                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                <LinkedObjectName />\
                <Rotation>Rotation0</Rotation>\
                <IsMirrored>False</IsMirrored>\
                <IsVariable>False</IsVariable>\
                <GroupID>-1</GroupID>\
                <IsOutlined>False</IsOutlined>\
                <Text>425078184891</Text>\
                <Type>Ean13</Type>\
                <Size>Small</Size>\
                <TextPosition>Bottom</TextPosition>\
                <TextFont Family="Arial" Size="8" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                <CheckSumFont Family="Arial" Size="8" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                <TextEmbedding>Full</TextEmbedding>\
                <ECLevel>0</ECLevel>\
                <HorizontalAlignment>Center</HorizontalAlignment>\
                <QuietZonesPadding Left="0" Top="0" Right="0" Bottom="0" />\
                </BarcodeObject>\
                <Bounds X="425.062683105469" Y="4143.60009765625" Width="1491.87463378906" Height="795" />\
                </ObjectInfo>\
                <ObjectInfo>\
                <TextObject>\
                <Name>TEXT__1</Name>\
                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                <LinkedObjectName />\
                <Rotation>Rotation0</Rotation>\
                <IsMirrored>False</IsMirrored>\
                <IsVariable>False</IsVariable>\
                <GroupID>-1</GroupID>\
                <IsOutlined>False</IsOutlined>\
                <HorizontalAlignment>Left</HorizontalAlignment>\
                <VerticalAlignment>Bottom</VerticalAlignment>\
                <TextFitMode>None</TextFitMode>\
                <UseFullFontHeight>True</UseFullFontHeight>\
                <Verticalized>False</Verticalized>\
                <StyledText>\
                <Element>\
                <String xml:space="preserve">Größe / Size:</String>\
            <Attributes>\
            <Font Family="Arial" Size="12" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" HueScale="100" />\
                </Attributes>\
                </Element>\
                </StyledText>\
                </TextObject>\
                <Bounds X="81.5999984741211" Y="1060.6884765625" Width="1981.39416503906" Height="257.142852783203" />\
                </ObjectInfo>\
                <ObjectInfo>\
                <TextObject>\
                <Name>TEXT___1</Name>\
                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                <LinkedObjectName />\
                <Rotation>Rotation0</Rotation>\
                <IsMirrored>False</IsMirrored>\
                <IsVariable>False</IsVariable>\
                <GroupID>-1</GroupID>\
                <IsOutlined>False</IsOutlined>\
                <HorizontalAlignment>Left</HorizontalAlignment>\
                <VerticalAlignment>Bottom</VerticalAlignment>\
                <TextFitMode>None</TextFitMode>\
                <UseFullFontHeight>True</UseFullFontHeight>\
                <Verticalized>False</Verticalized>\
                <StyledText>\
                <Element>\
                <String xml:space="preserve">Farbe / Color:</String>\
            <Attributes>\
            <Font Family="Arial" Size="12" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" HueScale="100" />\
                </Attributes>\
                </Element>\
                </StyledText>\
                </TextObject>\
                <Bounds X="88.1514892578125" Y="1813.18872070313" Width="1701.1083984375" Height="303.257141113281" />\
                </ObjectInfo>\
                <ObjectInfo>\
                <TextObject>\
                <Name>TEXT</Name>\
                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                <LinkedObjectName />\
                <Rotation>Rotation0</Rotation>\
                <IsMirrored>False</IsMirrored>\
                <IsVariable>False</IsVariable>\
                <GroupID>-1</GroupID>\
                <IsOutlined>False</IsOutlined>\
                <HorizontalAlignment>Left</HorizontalAlignment>\
                <VerticalAlignment>Top</VerticalAlignment>\
                <TextFitMode>None</TextFitMode>\
                <UseFullFontHeight>True</UseFullFontHeight>\
                <Verticalized>False</Verticalized>\
                <StyledText>\
                <Element>\
                <String xml:space="preserve">'+sup_refference+'</String>\
                <Attributes>\
                <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" HueScale="100" />\
                </Attributes>\
                </Element>\
                </StyledText>\
                </TextObject>\
                <Bounds X="105.00244140625" Y="639.382080078125" Width="1576.9951171875" Height="234.857147216797" />\
                </ObjectInfo>\
                <ObjectInfo>\
                <TextObject>\
                <Name>TEXT_1</Name>\
                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                <LinkedObjectName />\
                <Rotation>Rotation0</Rotation>\
                <IsMirrored>False</IsMirrored>\
                <IsVariable>False</IsVariable>\
                <GroupID>-1</GroupID>\
                <IsOutlined>False</IsOutlined>\
                <HorizontalAlignment>Left</HorizontalAlignment>\
                <VerticalAlignment>Top</VerticalAlignment>\
                <TextFitMode>None</TextFitMode>\
                <UseFullFontHeight>True</UseFullFontHeight>\
                <Verticalized>False</Verticalized>\
                <StyledText>\
                <Element>\
                <String xml:space="preserve">'+size+'</String>\
                <Attributes>\
                <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" HueScale="100" />\
                </Attributes>\
                </Element>\
                </StyledText>\
                </TextObject>\
                <Bounds X="90.00244140625" Y="1343.31323242188" Width="1171.9951171875" Height="339.857147216797" />\
                </ObjectInfo>\
                <ObjectInfo>\
                <TextObject>\
                <Name>TEXT___2</Name>\
                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                <LinkedObjectName />\
                <Rotation>Rotation0</Rotation>\
                <IsMirrored>False</IsMirrored>\
                <IsVariable>False</IsVariable>\
                <GroupID>-1</GroupID>\
                <IsOutlined>False</IsOutlined>\
                <HorizontalAlignment>Left</HorizontalAlignment>\
                <VerticalAlignment>Top</VerticalAlignment>\
                <TextFitMode>None</TextFitMode>\
                <UseFullFontHeight>True</UseFullFontHeight>\
                <Verticalized>False</Verticalized>\
                <StyledText>\
                <Element>\
                <String xml:space="preserve">'+dbk_name+'</String>\
            <Attributes>\
            <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" HueScale="100" />\
                </Attributes>\
                </Element>\
                </StyledText>\
                </TextObject>\
                <Bounds X="81.5999984741211" Y="2100.30883789063" Width="2083.38061523437" Height="992.710815429688" />\
                </ObjectInfo>\
                <ObjectInfo>\
                <TextObject>\
                <Name>TEXT_2</Name>\
                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                <LinkedObjectName />\
                <Rotation>Rotation0</Rotation>\
                <IsMirrored>False</IsMirrored>\
                <IsVariable>False</IsVariable>\
                <GroupID>-1</GroupID>\
                <IsOutlined>False</IsOutlined>\
                <HorizontalAlignment>Left</HorizontalAlignment>\
                <VerticalAlignment>Top</VerticalAlignment>\
                <TextFitMode>ShrinkToFit</TextFitMode>\
                <UseFullFontHeight>True</UseFullFontHeight>\
                <Verticalized>False</Verticalized>\
                <StyledText>\
                <Element>\
                <String xml:space="preserve">Preis / Price:</String>\
            <Attributes>\
            <Font Family="Arial" Size="12" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" HueScale="100" />\
                </Attributes>\
                </Element>\
                </StyledText>\
                </TextObject>\
                <Bounds X="141.599998474121" Y="3285" Width="1498.19995117188" Height="285" />\
                </ObjectInfo>\
                <ObjectInfo>\
                <TextObject>\
                <Name>TEXT_4</Name>\
                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                <LinkedObjectName />\
                <Rotation>Rotation0</Rotation>\
                <IsMirrored>False</IsMirrored>\
                <IsVariable>False</IsVariable>\
                <GroupID>-1</GroupID>\
                <IsOutlined>False</IsOutlined>\
                <HorizontalAlignment>Left</HorizontalAlignment>\
                <VerticalAlignment>Top</VerticalAlignment>\
                <TextFitMode>ShrinkToFit</TextFitMode>\
                <UseFullFontHeight>True</UseFullFontHeight>\
                <Verticalized>False</Verticalized>\
                <StyledText>\
                <Element>\
                <String xml:space="preserve">'+price+' €</String>\
            <Attributes>\
            <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                <ForeColor Alpha="255" Red="0" Green="0" Blue="0" HueScale="100" />\
                </Attributes>\
                </Element>\
                </StyledText>\
                </TextObject>\
                <Bounds X="126.599998474121" Y="3630" Width="1003.19995117187" Height="405" />\
                </ObjectInfo>\
                </DieCutLabel>';



                var label = dymo.label.framework.openLabelXml(labelXml);
               // var label = dymo.label.framework.openLabelFile(labelUri).getLabelXml();


                // create label set to print data
                var labelSetBuilder = new dymo.label.framework.LabelSetBuilder();

                // first label
                var record = labelSetBuilder.addRecord();
                record.setText("Text", sup_refference);


             /*  var image = document.createElement('img');
               // var labelXml1 = dymo.label.framework.openLabelXml(labelXml);
                var pngData = dymo.label.framework.renderLabel(label, "", printerName);
                image.src = "data:image/png;base64," + pngData;
                document.getElementById("top_container").appendChild(image);*/

                // create label set to print data
                //var labelSetBuilder = new dymo.label.framework.LabelSetBuilder();


                var labelk = dbk_name + '<br>' + sup_refference + '<br>' + size + '<br>' + price;

                // first label
               // var record = labelSetBuilder.addRecord();
                //record.setText("Text", labelk);



               // label.print(printerName, "", labelSetBuilder);
                label.print(printerName);
                 success = true;
            }
            catch(e)
            {
                alert(e.message || e);
            }
        });

        if(success) {
            alert("Label(s) are printed");
        }
    };

   /*function initTests()
	{
		if(dymo.label.framework.init)
		{
			//dymo.label.framework.trace = true;
			dymo.label.framework.init(onload);
		} else {
			onload();
		}
	}

	// register onload event
	if (window.addEventListener)
		window.addEventListener("load", initTests, false);
	else if (window.attachEvent)
		window.attachEvent("onload", initTests);
	else
		window.onload = initTests;
*/
