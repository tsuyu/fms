<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title></title>
        <style>
@media print {
.header, .hide { visibility: hidden }
}
</style>
	<script type="text/javascript" src="../include/js/jquery.min.js"></script>
	<script src="../include/barcode/EAN_UPC.js"></script>
	<script src="../include/barcode/CODE128.js"></script>
	<script src="../include/barcode/JsBarcode.js"></script>
</head>
<body>
	<div>
		<img id="barcode3"/>
		<script>$("#barcode3").JsBarcode("1010101010100000001",{
                    format:"CODE128",
                    width:  1,
                    height: 50,
                    quite: 10,
                    format: "CODE128",
                    displayValue: true,
                    font:"arial",
                    textAlign:"center",
                    fontSize: 20,
                    backgroundColor:"",
                    lineColor:"#000"
                });</script>
	</div>
</body>
</html>
