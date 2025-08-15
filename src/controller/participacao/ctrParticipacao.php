<?php

require_once("../../lib/libDatabase.php");
require_once("../../lib/libUtils.php");

require_once("../../model/mdlTbParticipacao.php");
require_once("../../model/mdlTbColaborador.php");
require_once("../../model/mdlTbTreinamento.php");

$objTbParticipacao = new TbParticipacao();
$objTbColaborador = new TbColaborador();
$objTbTreinamento = new TbTreinamento();
$objMsg = new Message();
$fmt = new Format();

//--------------------------------------------------------------------------------------------------------//
// Ação de Abertura da Tela de Consulta
//--------------------------------------------------------------------------------------------------------//
if (isset($_GET["action"]) && $_GET["action"] == "winConsulta") {
  $idTreinamento = $_GET["idTreinamento"];
  $idColaborador = $_GET["idColaborador"];

  require_once "../../view/participacao/viwConsultaParticipacao.php";
}
//--------------------------------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------------------------------//
// Ação de Inclusão de Registros
//--------------------------------------------------------------------------------------------------------//
if (isset($_GET["action"]) && $_GET["action"] == "incluir") {
  require_once "../../view/participacao/viwCadastroParticipacao.php";
}
//--------------------------------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------------------------------//
// Ação de Inclusão Múltipla de Registros
//--------------------------------------------------------------------------------------------------------//
if (isset($_GET["action"]) && $_GET["action"] == "incluirMulti") {
  $idTreinamento = $_GET["idTreinamento"];

  $objTbTreinamento = TbTreinamento::LoadByIdTreinamento($idTreinamento);

  require_once "../../view/participacao/viwMultiploCadastroParticipacao.php";
}
//--------------------------------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------------------------------//
// Ação de Edição de Registros
//--------------------------------------------------------------------------------------------------------//
if (isset($_GET["action"]) && $_GET["action"] == "editar") {
  $idParticipacao = $_GET["idParticipacao"];

  $objTbParticipacao = TbParticipacao::LoadByIdParticipacao($idParticipacao);

  require_once "../../view/participacao/viwCadastroParticipacao.php";
}
//--------------------------------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------------------------------//
// Ação de Listagem de Registros
//--------------------------------------------------------------------------------------------------------//
if (isset($_GET["action"]) && $_GET["action"] == "ListParticipacao") {
  $objFilter = new Filter($_GET);

  $strCondicao = $objFilter->GetWhere();

  if(isset($_GET["arrIdColaborador"]) && is_array($_GET["arrIdColaborador"])) {
    $strCondicao .= "AND pa.idcolaborador IN (".implode(",", $_GET["arrIdColaborador"]).")";
  }

  if(isset($_GET["arrIdTreinamento"]) && is_array($_GET["arrIdTreinamento"])) {
    $strCondicao .= "AND pa.idtreinamento IN (".implode(",", $_GET["arrIdTreinamento"]).")";
  }

  global $_intTotalParticipacao;

  $aroTbParticipacao = TbParticipacao::ListByCondicao($strCondicao, $objFilter->GetOrderBy());

  if (is_array($aroTbParticipacao) && count($aroTbParticipacao) > 0) {
    $arrLinhas = [];
    $arrTempor = [];

    foreach ($aroTbParticipacao as $objTbParticipacao) {
      $arrTempor["idparticipacao"] = utf8_encode($objTbParticipacao->Get("idparticipacao"));
      $arrTempor["idtreinamento"] = utf8_encode($objTbParticipacao->Get("idtreinamento"));
      $arrTempor["idcolaborador"] = utf8_encode($objTbParticipacao->Get("idcolaborador"));
      $arrTempor["dstitulo"] = utf8_encode($objTbParticipacao->Get("dstitulo"));
      $arrTempor["nmcolaborador"] = utf8_encode($objTbParticipacao->Get("nmcolaborador"));

      array_push($arrLinhas, $arrTempor);
    }

    echo '{ "jsnTotal": ' . $_intTotalParticipacao . ', "jsnParticipacao": ' . json_encode($arrLinhas) . ' }';
  } else if (!is_array($aroTbParticipacao) && trim($aroTbParticipacao) != "") {
    echo '{ "error": "' . utf8_encode($aroTbParticipacao) . '" }';
  } else {
    echo '{ "jsnParticipacao": null }';
  }
}
//--------------------------------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------------------------------//
// Ação para Gravação de Registros
//--------------------------------------------------------------------------------------------------------//
if (isset($_GET["action"]) && $_GET["action"] == "gravar") {
  $objTbParticipacao->Set("idparticipacao", utf8_decode($_POST['idParticipacao']));
  $objTbParticipacao->Set("idtreinamento", utf8_decode($_POST['idTreinamento']));
  $objTbParticipacao->Set("idcolaborador", utf8_decode($_POST['idColaborador']));

  $strMessage = "";

  if ($objTbParticipacao->Get("idtreinamento") == "") {
    $strMessage .= "&raquo; O campo <strong>Treinamento</strong> é de preenchimento obrigatório.<br>";
  }

  if ($objTbParticipacao->Get("idcolaborador") == "") {
    $strMessage .= "&raquo; O campo <strong>Colaborador</strong> é de preenchimento obrigatório.<br>";
  }

  if ($strMessage != "") {
    $objMsg->Alert("dlg", $strMessage);
  } else {
    if ($objTbParticipacao->Get("idparticipacao") != "") {
      $arrResult = $objTbParticipacao->Update($objTbParticipacao);

      if ($arrResult["dsMsg"] == "ok") {
        $objMsg->Succes("ntf", "Registro alterado com sucesso!");
        $objTbParticipacao = new TbParticipacao();
      } else {
        $objMsg->LoadMessage($arrResult);
      }
    } else {
      $arrResult = $objTbParticipacao->Insert($objTbParticipacao);

      if ($arrResult["dsMsg"] == "ok") {
        $objMsg->Succes("ntf", "Registro inserido com sucesso!");
        $objTbParticipacao = new TbParticipacao();
      } else {
        $objMsg->LoadMessage($arrResult);
      }
    }
  }
}
//--------------------------------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------------------------------//
// Ação para Inserção de Múltiplos de Registros
//--------------------------------------------------------------------------------------------------------//
if (isset($_GET["action"]) && $_GET["action"] == "inserirMulti") {

  $objTbParticipacao->Set("idtreinamento", utf8_decode($_POST['idTreinamento']));

  $arrIdColaborador = is_array($_POST['arrIdColaborador']) ? $_POST['arrIdColaborador'] : [];

  $strMessage = "";

  if ($objTbParticipacao->Get("idtreinamento") == "") {
    $strMessage .= "&raquo; O campo <strong>Treinamento</strong> é de preenchimento obrigatório.<br>";
  }

  if ($strMessage != "") {
    $objMsg->Alert("dlg", $strMessage);
  } else {
    $dtbLink = new DtbServer();
    $objTbParticipacao->SetDtbLink($dtbLink);

    $dtbLink->Begin();
    foreach ($arrIdColaborador as $idColaborador) {
      $objTbParticipacao->Set("idcolaborador", $idColaborador);
      $arrResult = $objTbParticipacao->Insert($objTbParticipacao);

      if ($arrResult["dsMsg"] !== "ok") {
        $objMsg->LoadMessage($arrResult);

        $dtbLink->Rollback();

        exit;
      }
    }
    $dtbLink->Commit();
  }

  $objMsg->Succes("ntf", "Registro inserido com sucesso!");
  $objTbParticipacao = new TbParticipacao();
}

//--------------------------------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------------------------------//
// Ação para Exclusão de Registros
//--------------------------------------------------------------------------------------------------------//
if (isset($_GET["action"]) && $_GET["action"] == "excluir") {
  $objTbParticipacao = TbParticipacao::LoadByIdParticipacao($_POST["idParticipacao"]);

  $arrResult = $objTbParticipacao->Delete($objTbParticipacao);

  if ($arrResult["dsMsg"] == "ok") {
    $objMsg->Succes("ntf", "Registro excluido com sucesso!");
    $objTbParticipacao = new TbParticipacao();
  } else {
    $objMsg->LoadMessage($arrResult);
  }
}
//--------------------------------------------------------------------------------------------------------//

