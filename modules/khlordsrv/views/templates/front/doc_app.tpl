<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Documentation</title>
</head>
<body>
<p>
	This is web service to send orders and customers to koehlert.com.
	URL: https://www.koehlert.com/module/khlordsrv/orders
</p>

<h2>Create order</h2>
<h3>Request</h3>
<p></p>
<h4>GET parameters</h4>
<dl>
	<dt>ws_key</dt>
	<dd>Created on koehlert.com by staff</dd>
	<dt>action</dt>
	<dd>create</dd>
</dl>
<p>
	Data must be sent in POST body using JSON format
</p>
<h4>POST parameters</h4>
<dl>
	<dt>customer_id</dt>
	<dd>ID of the customer in koehlert.com shop</dd>
	<dt>employee_id</dt>
	<dd>ID of the staff who is creating this order</dd>
    <dt>order_type_id</dt>
    <dd>ID of the order type</dd>
	<dt>note</dt>
	<dd>Note for the order. Optional.</dd>
	<dt>products</dt>
	<dd>Array of products to be added to the order. 
		To identify product one of the "supplier_reference" or "ean13" must be specified. 
		"quantity" - quantity to order
	</dd>

</dl>

<h5>Example</h5>
<pre><code>
{
	"customer_id": 123,
	"employee_id": 10,
	"products":[
		{
			"supplier_reference" : "ref_1",
			"quantity" : "1"
		},
		{
			"ean13" : "1234567890123",
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
		"invoices": [
			{
				"id": "0000",
				"number": "#IN000000", // invoice's reference (display number)
				"url": "http://domain.com/invoices_print/000_0000.pdf" // url of invoice's pdf 
			}
		],
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

<hr>
<h2>Get languages</h2>
<h3>Request</h3>
<p>
	URL: https://www.koehlert.com/api/languages
</p>
<h4>GET parameters</h4>
<dl>
	<dt>ws_key</dt>
	<dd>Created on koehlert.com by staff</dd>
	<dt>output_format</dt>
	<dd>Response format, JSON or XML</dd>
	<dt>display</dt>
	<dd>full</dd>
</dl>

<hr>

<h2>Create customer</h2>
<h3>Request</h3>
<p></p>
<h4>GET parameters</h4>
<dl>
	<dt>ws_key</dt>
	<dd>Created on koehlert.com by staff</dd>
	<dt>action</dt>
	<dd>create</dd>
</dl>
<p>
	Data must be sent in POST body using JSON format
</p>
<h4>POST parameters</h4>
<dl>
	<dt>firstname</dt>
	<dd>Customer's first name</dd>
	<dt>lastname</dt>
	<dd>Customer's last name</dd>
	<dt>email</dt>
	<dd>Customer's email</dd>
	<dt>company</dt>
	<dd>Customer's company name</dd>
	<dt>siret</dt>
	<dd>Customer's company VAT number</dd>
	<dt>phone</dt>
	<dd>Customer's phone</dd>
	<dt>country_id</dt>
	<dd>Customer's address country ID</dd>
	<dt>city</dt>
	<dd>Customer's address city</dd>
	<dt>postcode</dt>
	<dd>Customer's address postcode</dd>
	<dt>address1</dt>
	<dd>Customer's address first line</dd>
	<dt>address2</dt>
	<dd>Customer's address second line. Optional</dd>
	<dt>lang_id</dt>
	<dd>Language ID in koehlert.com system</dd>
</dl>

<h5>Example</h5>
<pre><code>
{
	"firstname": "John",
	"lastname": "Doe"
}
</code></pre>
<h3>Response</h3>
<p></p>
<pre><code>
{
	"success" : true, // "true" on success, "false" on failure
	"messages" : "", // filled with error messages on failure
	"data" : { // empty on failure
		"customer" : {
			"id": "000",
			"lastname": "Doe",
            "firstname": "John",
		}
	}
}
</code></pre>

</body>
</html>