<?php

class AdminShopCommentsCommentsController extends ModuleAdminController
{
    protected $referenceType = null;
    
    protected $referenceId = null;
    
    public function initProcess()
    {
        parent::initProcess();
        
        /*$referenceRaw = $_REQUEST['reference'];
        
        switch($referenceRaw){
            case 'customer':
                $this->referenceType = ShopComment::REFERENCE_TYPE_CUSTOMER;
                break;
            case 'diff_payment':
                $this->referenceType = ShopComment::REFERENCE_TYPE_DIFFPMNT;
                break;
        
        }*/
        
    }
    
    public function processList()
    {
        $this->ajax = true;
        $referenceId = intval($_GET['reference_id']);
        $referenceType = intval($_GET['reference_type']);
        $commentStatus = null;
        if( isset($_GET['status']) && (($_GET['status'] == '0') || !empty($_GET['status'])) ){
            $commentStatus = intval($_GET['status']);
        }
        
        $comments = ShopComment::getComments($referenceType, $referenceId, $commentStatus);
        $commentsStatusText = 'all';
        if(!is_null($commentStatus)){
            $commentsStatusText = $commentStatus ? 'active' : 'archived';
        }
        $this->context->smarty->assign(array(
            'comments' => $comments,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'comments_status_text' => $commentsStatusText
        ));
        
        $this->context->smarty->display($this->module->getTemplatePath('views/templates/admin/list.tpl'));
    }
    
    public function processSave()
    {
        //$this->ajax = true;
        $responseData = array('status' => 'error');
        $referenceId = intval($_POST['reference_id']);
        $referenceType = intval($_POST['reference_type']);
        $message = $_POST['message'];
        $message = htmlentities( strip_tags($message) );
        
        $isAjax = isset($_POST['ajax']);
        
        $shopComment = new ShopComment();
        $shopComment->reference_type = $referenceType;
        $shopComment->reference_id = $referenceId;
        $shopComment->employee_id = $this->context->employee->id;
        $shopComment->message = $message;
        $shopComment->date_created = date('Y-m-d H:i:s');
        $shopComment->status = ShopComment::STATUS_ACTIVE;
        
        try{
            $shopComment->add();
        }
        catch(Exception $e){
            
            if($isAjax){
                $responseData['message'] = $e->getMessage();
                echo json_encode($responseData);
                die;
            }
            else{
                throw $e;
            }
        }
        
        $responseData['status'] = 'ok';
        
        if($isAjax){
            echo json_encode($responseData);
        }
        else{
            if( strpos($_SERVER['HTTP_REFERER'], 'AdminOrders') ){
                $redirectUrl = $_SERVER['HTTP_REFERER'];
            }
            elseif($referenceType == ShopComment::REFERENCE_TYPE_CUSTOMER){
                $redirectUrl = $this->context->link->getAdminLink('AdminCustomers');
            }
            elseif($referenceType == ShopComment::REFERENCE_TYPE_DIFFPMNT){
                $redirectUrl = $this->context->link->getAdminLink('AdminDiffPayments');
            }
            Tools::redirectAdmin($redirectUrl);
        }
    }
    
    public function processChangeStatus()
    {
        $this->ajax = true;
        $responseData = array('status' => 'error');
        $commentId = intval(@$_POST['id']);
        $commentStatus = intval($_POST['status']);
        
        $shopComment = new ShopComment($commentId);
        if( !Validate::isLoadedObject($shopComment) ){
            $responseData['message'] = 'Comment can not be loaded';
            echo json_encode($responseData);
            die;
        }
        
        
        $shopComment->status = $commentStatus;
        
        try{
            $shopComment->save();
        }
        catch(Exception $e){
            $responseData['message'] = $e->getMessage();
            echo json_encode($responseData);
            die;
        }
        
        $responseData['status'] = 'ok';
        $responseData['data'] = $shopComment->getFields();
        echo json_encode($responseData);
        die;
        
    }
}