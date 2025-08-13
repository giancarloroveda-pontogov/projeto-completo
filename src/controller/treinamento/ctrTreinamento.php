<?php

require_once("../../lib/libDatabase.php");
require_once("../../lib/libUtils.php");

require_once("../../model/mdlTbTreinamento.php");

$objTbTreinamento = new TbTreinamento();
$objMsg = new Message();
$fmt = new Format();

//--------------------------------------------------------------------------------------------------------//
// Ação de Abertura da Tela de Consulta
//--------------------------------------------------------------------------------------------------------//
if(isset($_GET["action"]) && $_GET["action"] == "winConsulta") {
  require_once "../../view/treinamento/viwConsultaTreinamento.php";
}
//--------------------------------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------------------------------//
// Ação de Inclusão de Registros
//--------------------------------------------------------------------------------------------------------//
if(isset($_GET["action"]) && $_GET["action"] == "incluir") {
  require_once "../../view/treinamento/viwCadastroTreinamento.php";
}
//--------------------------------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------------------------------//
// Ação de Edição de Registros
//--------------------------------------------------------------------------------------------------------//
if(isset($_GET["action"]) && $_GET["action"] == "editar") {
  $idTreinamento = $_GET["idTreinamento"];

  $objTbTreinamento = TbTreinamento::LoadByIdTreinamento($idTreinamento);

  require_once "../../view/treinamento/viwCadastroTreinamento.php";
}
//--------------------------------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------------------------------//
// Ação de Listagem de Registros
//--------------------------------------------------------------------------------------------------------//
if(isset($_GET["action"]) && $_GET["action"] == "ListTreinamento") {
  $objFilter = new Filter($_GET);

  global $_intTotalTreinamento;

  $aroTbTreinamento = TbTreinamento::ListByCondicao($objFilter->GetWhere(), $objFilter->GetOrderBy());

  if(is_array($aroTbTreinamento) && count($aroTbTreinamento) > 0) {
    $arrLinhas = [];
    $arrTempor = [];

    foreach($aroTbTreinamento as $objTbTreinamento) {
      $arrTempor["idtreinamento"] = utf8_encode($objTbTreinamento->Get("idtreinamento"));
      $arrTempor["dstitulo"] = utf8_encode($objTbTreinamento->Get("dstitulo"));
      $arrTempor["dsdescricao"] = utf8_encode($objTbTreinamento->Get("dsdescricao"));
      $arrTempor["dsareatecnica"] = utf8_encode($objTbTreinamento->Get("dsareatecnica"));
      $arrTempor["nrcargahoraria"] = utf8_encode($objTbTreinamento->Get("nrcargahoraria"));
      $arrTempor["fltipo"] = utf8_encode($objTbTreinamento->Get("fltipo"));

      $arrTempor["dstipo"] = "";

      switch($objTbTreinamento->Get("fltipo")) {
        case "T":
          $arrTempor["dstipo"] = utf8_encode("Técnico");
          break;
        case "C":
          $arrTempor["dstipo"] = utf8_encode("Comportamental");
          break;
      }

      array_push($arrLinhas, $arrTempor);
    }

    echo '{ "jsnTotal": '.$_intTotalTreinamento.', "jsnTreinamento": '.json_encode($arrLinhas).' }';
  } else if (!is_array($aroTbTreinamento) && trim($aroTbTreinamento) != "") {
    echo '{ "error": "'.utf8_encode($aroTbTreinamento).'" }';
  } else {
    echo '{ "jsnTreinamento": null }';
  }
}
//--------------------------------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------------------------------//
// Ação para Gravação de Registros
//--------------------------------------------------------------------------------------------------------//
if(isset($_GET["action"]) && $_GET["action"] == "gravar") {
  $objTbTreinamento->Set("idtreinamento", $_POST['idTreinamento']);
  $objTbTreinamento->Set("dstitulo", utf8_decode($_POST['dsTitulo']));
  $objTbTreinamento->Set("dsdescricao", utf8_decode($_POST['dsDescricao']));
  $objTbTreinamento->Set("dsareatecnica", utf8_decode($_POST['dsAreaTecnica']));
  $objTbTreinamento->Set("nrcargahoraria", $_POST['nrCargaHoraria']);
  $objTbTreinamento->Set("fltipo", utf8_decode($_POST['flTipo']));

  $strMessage = "";

  if($objTbTreinamento->Get("dstitulo") == "") {
    $strMessage .= "&raquo; O campo <strong>Título</strong> é de preenchimento obrigatório.<br>";
  }

  if($objTbTreinamento->Get("dsareatecnica") == "") {
    $strMessage .= "&raquo; O campo <strong>Área Técnica</strong> é de preenchimento obrigatório.<br>";
  }

  if($objTbTreinamento->Get("nrcargahoraria") == "") {
    $strMessage .= "&raquo; O campo <strong>Carga Horária</strong> é de preenchimento obrigatório.<br>";
  }

  if($objTbTreinamento->Get("fltipo") == "") {
    $strMessage .= "&raquo; O campo <strong>Tipo</strong> é de preenchimento obrigatório.<br>";
  }

  if($strMessage != "") {
    $objMsg->Alert("dlg", $strMessage);
  } else {
    if($objTbTreinamento->Get("idtreinamento") != "") {
      $arrResult = $objTbTreinamento->Update($objTbTreinamento);

      if($arrResult["dsMsg"] == "ok") {
        $objMsg->Succes("ntf", "Registro alterado com sucesso!");
        $objTbTreinamento = new TbTreinamento();
      } else {
        $objMsg->LoadMessage($arrResult);
      }
    } else {
      $arrResult = $objTbTreinamento->Insert($objTbTreinamento);

      if($arrResult["dsMsg"] == "ok") {
        $objMsg->Succes("ntf", "Registro inserido com sucesso!");
        $objTbTreinamento = new TbTreinamento();
      } else {
        $objMsg->LoadMessage($arrResult);
      }
    }
  }
}
//--------------------------------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------------------------------//
// Ação para Exclusão de Registros
//--------------------------------------------------------------------------------------------------------//
if(isset($_GET["action"]) && $_GET["action"] == "excluir") {
  $objTbTreinamento = TbTreinamento::LoadByIdTreinamento($_POST["idTreinamento"]);

  $arrResult = $objTbTreinamento->Delete($objTbTreinamento);

  if($arrResult["dsMsg"] == "ok") {
    $objMsg->Succes("ntf", "Registro excluido com sucesso!");
    $objTbTreinamento = new TbTreinamento();
  } 
  else {
    $objMsg->LoadMessage($arrResult);
  }
}
//--------------------------------------------------------------------------------------------------------//

