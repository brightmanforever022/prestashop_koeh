<?php
/**
 * Store Commander
 *
 * @category administration
 * @author Store Commander - support@storecommander.com
 * @version 2015-09-15
 * @uses Prestashop modules
 * @since 2009
 * @copyright Copyright &copy; 2009-2015, Store Commander
 * @license commercial
 * All rights reserved! Copying, duplication strictly prohibited
 *
 * *****************************************
 * *           STORE COMMANDER             *
 * *   http://www.StoreCommander.com       *
 * *            V 2015-09-15               *
 * *****************************************
 *
 * Compatibility: PS version: 1.1 to 1.6.1
 *
 **/
/**
 * Store Commander
 *
 * @category administration
 * @author Store Commander - support@storecommander.com
 * @version 2015-09-15
 * @uses Prestashop modules
 * @since 2009
 * @copyright Copyright &copy; 2009-2015, Store Commander
 * @license commercial
 * All rights reserved! Copying, duplication strictly prohibited
 *
 * *****************************************
 * *           STORE COMMANDER             *
 * *   http://www.StoreCommander.com       *
 * *            V 2015-09-15               *
 * *****************************************
 *
 * Compatibility: PS version: 1.1 to 1.6.1
 *
 **/
 
	require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "config.php");
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
    	<a href="#" class="jqmClose" id="windowSaveClose"><?php echo IMG_BTN_CANCEL; ?></a>
      <form id="formSaveAs" name="formSaveAs" action="" method="post">
    	<table class="tableForm" cellpadding="0" cellspacing="0">
      	<thead>
        	<tr>
          	<th colspan="2"><?php echo IMG_LBL_SAVE_AS; ?></th>
          </tr>
        </thead>
        <tbody>
        	<tr>
          	<th>
            	<label><?php echo IMG_LBL_NEW_NAME; ?></label>
            </th>
            <td>
            	<input type="text" id="new_name" class="input" name="new_name" value="" />
            </td>
          </tr>
          <tr>
          	<th>
            	<label><?php echo IMG_LBL_SAVE_TO; ?></label>
            </th>
            <td>
            	<select class="input" name="save_to">
              	
              </select>
            </td>
          </tr>
          <tr>
          	<th>&nbsp;
            </th>
            <td>
            <span class="comments">*</span>
            <?php echo IMG_NEW_NAME_COMMENTS; ?>
            </td>
          </tr>
        </tbody>
        <tfoot>
        	<tr>
        	<th>&nbsp;</th>
          <td><input type="button" class="button" value="<?php echo IMG_BTN_SAVE_AS; ?>" onclick="return saveAsImage();" /></td>
          </tr>
        </tfoot>
      </table>
</body>
</html>
