<?php

class TbColaborador {
  //--------------------------------------------------------------------------------------------------------//
  // Métodos de Definição da Classe [CLASS]
  //--------------------------------------------------------------------------------------------------------//  

  // Propriedades Persistentes
  private $idcolaborador;
  private $nmcolaborador;
  private $dsemail;
  private $dssetor;
  private $dtcontratacao;

  /**
   * Metodo Construct para Limpeza do Objeto 
   */
  public function __construct() {
    $this->idcolaborador = "";
    $this->nmcolaborador = "";
    $this->dsemail = "";
    $this->dssetor = "";
    $this->dtcontratacao = "";
  }

  
  /**
   * Método Set para Carga do Objeto
   */
  public function Set($prpTbColaborador, $valTbColaborador) {
    $this->$prpTbColaborador = $valTbColaborador;
  }

  /**
   * Método Get para Busca do Objeto
   */
  public function Get($prpTbColaborador) {
    return $this->$prpTbColaborador;
  }

  /**
   * Carrega o Objeto com os dados do resultSet de uma query
   * @param $resSet -> ResultSet da Query
   * @return TbColaborador
   */
  public function LoadObject($resSet) {
    $fmt = new Format();

    $objTbColaborador = new TbColaborador();

    $objTbColaborador->Set("idcolaborador", $resSet['idcolaborador']);
    $objTbColaborador->Set("nmcolaborador", $resSet['nmcolaborador']);
    $objTbColaborador->Set("dsemail", $resSet['dsemail']);
    $objTbColaborador->Set("dssetor", $resSet['dssetor']);
    $objTbColaborador->Set("dtcontratacao", $fmt->data($resSet['dtcontratacao']));

    if(!isset($GLOBALS['_intTotalColaborador'])){
      $GLOBALS['_intTotalColaborador'] = $resSet['_inttotal'];
    }

    return $objTbColaborador;
  }

  //--------------------------------------------------------------------------------------------------------//
  // Métodos de Manutenção do Objeto
  //--------------------------------------------------------------------------------------------------------//

  /**
   * Insere um registro na tabela TbColaborador
   * @param $objTbColaborador -> Objeto com os dados a serem inseridos
   * @return string[]
   */
  public function Insert($objTbColaborador) {
    $dtbLink = new DtbServer();
    $fmt = new Format();

    $dsSql = "INSERT INTO
                shtreinamento.tbcolaborador(
                  idcolaborador,
                  nmcolaborador,
                  dsemail,
                  dssetor,
                  dtcontratacao
                )
              VALUES(
                (select nextval('shtreinamento.sqidcolaborador') as nextid),  
                '".$fmt->escSqlQuotes($objTbColaborador->Get("nmcolaborador"))."',  
                '".$fmt->escSqlQuotes($objTbColaborador->Get("dsemail"))."',  
                '".$fmt->escSqlQuotes($objTbColaborador->Get("dssetor"))."',  
                ".$fmt->DataBd($objTbColaborador->Get("dtcontratacao"))."
              );";

    if(!$dtbLink->ExecSql($dsSql)) {
      $arrMsg = $dtbLink->getMessage();
    }
    else {
      $arrMsg['dsMsg'] = "ok";
    }
    return $arrMsg;
  }
  
  /**
   * Insere um registro na tabela TbColaborador
   * @param $objTbColaborador -> Objeto com os dados a serem inseridos
   * @return string[]
   */
  public function InsertWithId($objTbColaborador) {
    $dtbLink = new DtbServer();
    $fmt = new Format();

    $dsSql = "INSERT INTO
                shtreinamento.tbcolaborador(
                  idcolaborador,
                  nmcolaborador,
                  dsemail,
                  dssetor,
                  dtcontratacao
                )
              VALUES(
                ".$fmt->NullBd($objTbColaborador->Get("idcolaborador"))."
                '".$fmt->escSqlQuotes($objTbColaborador->Get("nmcolaborador"))."',  
                '".$fmt->escSqlQuotes($objTbColaborador->Get("dsemail"))."',  
                '".$fmt->escSqlQuotes($objTbColaborador->Get("dssetor"))."',  
                ".$fmt->DataBd($objTbColaborador->Get("dtcontratacao"))."
              );";

    if(!$dtbLink->ExecSql($dsSql)) {
      $arrMsg = $dtbLink->getMessage();
    }
    else {
      $arrMsg['dsMsg'] = "ok";
    }
    return $arrMsg;
  }

  /**
   * Altera um registro na tabela TbColaborador
   * @param TbColaborador $objTbColaborador -> Objeto com os dados a serem alterados
   * @return string[]
   */
  public function Update($objTbColaborador) {
    $dtbLink = new DtbServer();
    $fmt = new Format();

    $dsSql = "UPDATE
                shtreinamento.tbcolaborador
              SET
                nmcolaborador = '".$fmt->escSqlQuotes($objTbColaborador->Get("nmcolaborador"))."',  
                dsemail = '".$fmt->escSqlQuotes($objTbColaborador->Get("dsemail"))."',  
                dssetor = '".$fmt->escSqlQuotes($objTbColaborador->Get("dssetor"))."',  
                dtcontratacao = ".$fmt->DataBd($objTbColaborador->Get("dtcontratacao"))."
              WHERE
                idcolaborador = ".$objTbColaborador->Get("idcolaborador").";";

    if(!$dtbLink->ExecSql($dsSql)) {
      $arrMsg = $dtbLink->getMessage();
    }
    else {
      $arrMsg['dsMsg'] = "ok";
    }
    return $arrMsg;
  }

  /**
   * Elimina registro na tabela TbColaborador
   * @param TbColaborador $objTbColaborador -> Objeto com os dados a serem eliminados
   * @return string[]
   */
  public function Delete($objTbColaborador) {
    $dtbLink = new DtbServer();

    $dsSql = "DELETE FROM
                shtreinamento.tbcolaborador
              WHERE
                idcolaborador = ".$objTbColaborador->Get("idcolaborador").";";

    if(!$dtbLink->ExecSql($dsSql)) {
      $arrMsg = $dtbLink->getMessage();
    }
    else {
      $arrMsg['dsMsg'] = "ok";
    }
    return $arrMsg;
  }

  //--------------------------------------------------------------------------------------------------------//
  // Métodos de Consulta do Objeto
  //--------------------------------------------------------------------------------------------------------//

  /**
   * Busca os dados na tabela pela condição da chave primária
   * @param $idColaborador -> Chave a ser buscada
   * @return TbColaborador
   */
  public static function LoadByIdColaborador($idColaborador) {
    $dtbLink = new DtbServer();
    $fmt = new Format();
    $objTbColaborador = new TbColaborador();

    $dsSql = "SELECT
                *
              FROM
                shtreinamento.tbcolaborador co
              WHERE
                idcolaborador = {$idColaborador};";

    if(!$dtbLink->Query($dsSql)) {
      return $fmt->RemoveQuebraLinha($dtbLink->getMessage()['dsMsg']."<br>");
    }
    else {
      $resSet = $dtbLink->FetchArray();
      $objTbColaborador = $objTbColaborador->LoadObject($resSet);
    }
    return $objTbColaborador;
  }

  /**
   * Busca os dados da tabela com parâmetros de condição e ordenação
   * @param $strCondicao -> Condição da pesquisa
   * @param $strOrdenacao -> Ordenação da pesquisa
   * @return TbColaborador[]
   */
  public static function ListByCondicao($strCondicao, $strOrdenacao) {
    $dtbLink = new DtbServer();
    $fmt = new Format();
    $objTbColaborador = new TbColaborador();

    $dsSql = "SELECT
                *,
                count(*) over() as _inttotal
              FROM
                shtreinamento.tbcolaborador co
              WHERE
                1 = 1 ";

    if($strCondicao != "") {
      $dsSql .= $strCondicao;
    }
    if($strOrdenacao != "") {
      $dsSql .= " ORDER BY {$strOrdenacao}";
    }

    if(!$dtbLink->Query($dsSql)) {
      return $fmt->RemoveQuebraLinha($dtbLink->getMessage()['dsMsg']."<br>");
    }
    else {
      while ($resSet = $dtbLink->FetchArray()) {
        $aroTbColaborador[] = $objTbColaborador->LoadObject($resSet);
      }
    }
    return $aroTbColaborador;
  }

  /**
   * Retorna o próximo id da sequência
   * @return int
   */
  public static function GetNextId(){
    $dtbLink = new DtbServer();
    $fmt = new Format();

    $dsSql = "SELECT nextval('shtreinamento.sqidcolaborador') as nextid";

    if(!$dtbLink->Query($dsSql)) {
      return $fmt->RemoveQuebraLinha($dtbLink->getMessage()['dsMsg']."<br>");
    }
    else {
      $resSet = $dtbLink->FetchArray();
      return $resSet['nextid'];
    }
  }
}