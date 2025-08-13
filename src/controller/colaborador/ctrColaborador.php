<?php

require_once("../../lib/libDatabase.php");
require_once("../../lib/libUtils.php");

require_once("../../model/mdlTbColaborador.php");

$objTbColaborador = new TbColaborador();
$objMsg = new Message();
$fmt = new Format();

if(isset($_GET["action"]) && $_GET["action"] == "winConsulta") {
  require_once "../../view/colaborador/viwConsultaColaborador.php";
}
//--------------------------------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------------------------------//
// Ação de Inclusão de Registros
//--------------------------------------------------------------------------------------------------------//
if(isset($_GET["action"]) && $_GET["action"] == "incluir") {
  require_once "../../view/colaborador/viwCadastroColaborador.php";
}
//--------------------------------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------------------------------//
// Ação de Edição de Registros
//--------------------------------------------------------------------------------------------------------//
if(isset($_GET["action"]) && $_GET["action"] == "editar") {
  $idColaborador = $_GET["idColaborador"];

  $objTbColaborador = TbColaborador::LoadByIdColaborador($idColaborador);

  require_once "../../view/colaborador/viwCadastroColaborador.php";
}
//--------------------------------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------------------------------//
// Ação de Listagem de Registros
//--------------------------------------------------------------------------------------------------------//
if(isset($_GET["action"]) && $_GET["action"] == "ListColaborador") {
  $objFilter = new Filter($_GET);

  global $_intTotalColaborador;

  $aroTbColaborador = TbColaborador::ListByCondicao($objFilter->GetWhere(), $objFilter->GetOrderBy());

  if(is_array($aroTbColaborador) && count($aroTbColaborador) > 0) {
    $arrLinhas = [];
    $arrTempor = [];

    foreach($aroTbColaborador as $objTbColaborador) {
      $arrTempor["idcolaborador"] = utf8_encode($objTbColaborador->Get("idcolaborador"));
      $arrTempor["nmcolaborador"] = utf8_encode($objTbColaborador->Get("nmcolaborador"));
      $arrTempor["dsemail"] = utf8_encode($objTbColaborador->Get("dsemail"));
      $arrTempor["dssetor"] = utf8_encode($objTbColaborador->Get("dssetor"));
      $arrTempor["dtcontratacao"] = utf8_encode($objTbColaborador->Get("dtcontratacao"));

      array_push($arrLinhas, $arrTempor);
    }

    echo '{ "jsnTotal": '.$_intTotalColaborador.', "jsnColaborador": '.json_encode($arrLinhas).' }';
  } else if (!is_array($aroTbColaborador) && trim($aroTbColaborador) != "") {
    echo '{ "error": "'.utf8_encode($aroTbColaborador).'" }';
  } else {
    echo '{ "jsnColaborador": null }';
  }
}
//--------------------------------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------------------------------//
// Ação para Gravação de Registros
//--------------------------------------------------------------------------------------------------------//
if(isset($_GET["action"]) && $_GET["action"] == "gravar") {
  $objTbColaborador->Set("idcolaborador", $_POST['idColaborador']);
  $objTbColaborador->Set("nmcolaborador", utf8_decode($_POST['nmColaborador']));
  $objTbColaborador->Set("dsemail", utf8_decode($_POST['dsEmail']));
  $objTbColaborador->Set("dssetor", utf8_decode($_POST['dsSetor']));
  $objTbColaborador->Set("dtcontratacao", $fmt->data($_POST['dtContratacao']));

  $strMessage = "";

  if($objTbColaborador->Get("nmcolaborador") == "") {
    $strMessage .= "&raquo; O campo <strong>Nome</strong> é de preenchimento obrigatório.<br>";
  }

  if($objTbColaborador->Get("dsemail") == "") {
    $strMessage .= "&raquo; O campo <strong>E-mail</strong> é de preenchimento obrigatório.<br>";
  }

  if($objTbColaborador->Get("dssetor") == "") {
    $strMessage .= "&raquo; O campo <strong>Setor</strong> é de preenchimento obrigatório.<br>";
  }

  if($objTbColaborador->Get("dtcontratacao") == "") {
    $strMessage .= "&raquo; O campo <strong>Data de Contratação</strong> é de preenchimento obrigatório.<br>";
  }

  if($strMessage != "") {
    $objMsg->Alert("dlg", $strMessage);
  } else {
    if($objTbColaborador->Get("idcolaborador") != "") {
      $arrResult = $objTbColaborador->Update($objTbColaborador);

      if($arrResult["dsMsg"] == "ok") {
        $objMsg->Succes("ntf", "Registro alterado com sucesso!");
        $objTbColaborador = new TbColaborador();
      } else {
        $objMsg->LoadMessage($arrResult);
      }
    } else {
      $arrResult = $objTbColaborador->Insert($objTbColaborador);

      if($arrResult["dsMsg"] == "ok") {
        $objMsg->Succes("ntf", "Registro inserido com sucesso!");
        $objTbColaborador = new TbColaborador();
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
  $objTbColaborador = TbColaborador::LoadByIdColaborador($_POST["idColaborador"]);

  $arrResult = $objTbColaborador->Delete($objTbColaborador);

  if($arrResult["dsMsg"] == "ok") {
    $objMsg->Succes("ntf", "Registro excluido com sucesso!");
    $objTbColaborador = new TbColaborador();
  }
  else {
    $objMsg->LoadMessage($arrResult);
  }
}
//--------------------------------------------------------------------------------------------------------//

