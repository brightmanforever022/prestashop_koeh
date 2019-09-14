<h2>{l s='Order package'} #{$orderPackage->id}{if $orderPackage->cancelled} ({l s='cancelled'}){/if}</h2>

<table>
    <tr>
        <td>{l s='Date:'}</td>
        <td>&nbsp;</td>
        <td>{dateFormat date=$orderPackage->date_add full=true}</td>
    </tr>
    <tr>
        <td>{l s='Employee:'}</td>
        <td>&nbsp;</td>
        <td>{$employeeName}</td>
    </tr>
</table>
<table class='table'>
    <thead>
    <tr>
        <th>{l s='Product'}</th>
        <th>{l s='Sku'}</th>
        <th>{l s='Quantity'}</th>
    </tr>
    </thead>
    <tbody>
    {foreach from=$opDetails item='detail'}
    <tr>
        <td>{$detail.product_name}</td>
        <td>{$detail.product_supplier_reference}</td>
        <td>{$detail.quantity}</td>
    </tr>
    {/foreach}
    </tbody>
</table>