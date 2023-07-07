<?php

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

use WHMCS\Module\Server\SimpleWHMCSModule\FileProcessor;

function simplewhmcsmodule_MetaData() : array
{
    return array(
        'DisplayName' => 'Simple WHMCS Module',
        'APIVersion' => '1.1',
        'RequiresServer' => true,
        'DefaultNonSSLPort' => '1111',
        'DefaultSSLPort' => '1112',
        'ServiceSingleSignOnLabel' => 'Login to Panel as User',
        'AdminSingleSignOnLabel' => 'Login to Panel as Admin',
    );
}

function simplewhmcsmodule_CreateAccount(array $params) : string {
    try{
        $clientData = $params["clientsdetails"];

        $fileProcessor = new FileProcessor();
        $fileProcessor->appendRecord($clientData["id"], $clientData["firstname"], $clientData["lastname"], $clientData["status"]);

    }catch (Exception $ex){
        logModuleCall(
            'simplewhmcsmodule',
            __FUNCTION__,
            $params,
            $ex->getMessage(),
            $ex->getTraceAsString()
        );
        return $ex->getMessage();
    }

    return "success";
}

function simplewhmcsmodule_TerminateAccount(array $params) : string {
    try{
        $fileProcessor = new FileProcessor();
        $fileProcessor->removeRecord($params["clientsdetails"]["id"]);
    }catch (Exception $ex){
        logModuleCall(
            'simplewhmcsmodule',
            __FUNCTION__,
            $params,
            $ex->getMessage(),
            $ex->getTraceAsString()
        );
        return $ex->getMessage();
    }

    return "success";
}

function simplewhmcsmodule_SuspendAccount(array $params) : string{
    try{
        $fileProcessor = new FileProcessor();
        $fileProcessor->updateRecord($params["clientsdetails"]["id"], "Suspended");
    }catch (Exception $ex){
        logModuleCall(
            'simplewhmcsmodule',
            __FUNCTION__,
            $params,
            $ex->getMessage(),
            $ex->getTraceAsString()
        );
        return $ex->getMessage();
    }
    return "success";
}

function simplewhmcsmodule_UnsuspendAccount(array $params) : string {
    try{
        $clientData = $params["clientsdetails"];
        $fileProcessor = new FileProcessor();
        $fileProcessor->updateRecord($clientData["id"], $clientData["status"]);
    }catch (Exception $ex){
        logModuleCall(
            'simplewhmcsmodule',
            __FUNCTION__,
            $params,
            $ex->getMessage(),
            $ex->getTraceAsString()
        );
        return $ex->getMessage();
    }
    return "success";
}


