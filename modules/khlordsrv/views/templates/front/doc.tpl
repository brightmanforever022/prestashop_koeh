<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Documentation</title>
</head>
<body>
<p>
	This is web service to send orders to koehlert.com.
	URL: https://www.koehlert.com/module/khlordsrv/orders
</p>

<h2>Create order</h2>
<h3>Request</h3>
<p></p>
<h4>GET parameters</h4>
<dl>
	<dt>auth_key</dt>
	<dd>Authentication key you received from koehlert.com staff</dd>
	<dt>action</dt>
	<dd>create</dd>
</dl>
<h4>POST parameters</h4>
<p>
	"products" to create order from, must be sent within POST body using JSON format. 
	To identify product one of the "supplier_reference" or "ean13" must be specified
</p>
<pre><code>
{
	"products":[
		{
			"supplier_reference" : "ref_1"
			"quantity" : "1"
		},
		{
			"ean13" : "1234567890123"
			"quantity" : "2"
		}
	]
}
</code></pre>
<h3>Response</h3>
<p></p>
<pre><code>
{
	"success" : true, // "true" on success, "false" on failure
	"message" : "", // filled with error message on failure
	"data" : { // empty on failure
		"id" : "123", // order ID
		"total_products_*" : "40", // products with tax and without
		"total_shipping_*" : "0", // shipping with tax and without
		"total_discounts_*" : "0", // discounts with tax and without
		"total_order_*" : "40", // order total with tax and without
		"products" : [
			{
				"name" : "name of product 1",
				"supplier_reference" : "ref_1",
				"ean13" : "1234567890123",
				"quantity" : "2",
				"price_tax_excl" : "20", // price of the item without taxes
				"total_tax_excl" : "40", // total of the items without taxes
				"total_tax_incl" : "47.6", // total of the items with taxes
			},
			// { ... }
		]
	}
}
</code></pre>
</body>
</html>