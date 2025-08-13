<?php

class TbTreinamento {
  //--------------------------------------------------------------------------------------------------------//
  // Métodos de Definição da Classe [CLASS]
  //--------------------------------------------------------------------------------------------------------//  

  // Propriedades Persistentes
  private $idtreinamento;
  private $dstitulo;
  private $dsdescricao;
  private $dsareatecnica;
  private $nrcargahoraria;
  private $fltipo;

  /**
   * Metodo Construct para Limpeza do Objeto 
   */
  public function __construct() {
    $this->idtreinamento = "";
    $this->dstitulo = "";
    $this->dsdescricao = "";
    $this->dsareatecnica = "";
    $this->nrcargahoraria = "";
    $this->fltipo = "";
  }

  /**
   * Método Set para Carga do Objeto
   */
  public function Set($prpTbTreinamento, $valTbTreinamento) {
    $this->$prpTbTreinamento = $valTbTreinamento;
  }

  /**
   * Método Get para Busca do Objeto
   */
  public function Get($prpTbTreinamento) {
    return $this->$prpTbTreinamento;
  }

  /**
   * Carrega o Objeto com os dados do resultSet de uma query
   * @param $resSet -> ResultSet da Query
   * @return TbTreinamento
   */
  public function LoadObject($resSet) {
    $objTbTreinamento = new TbTreinamento();

    $objTbTreinamento->Set("idtreinamento", $resSet['idtreinamento']);
    $objTbTreinamento->Set("dstitulo", $resSet['dstitulo']);
    $objTbTreinamento->Set("dsdescricao", $resSet['dsdescricao']);
    $objTbTreinamento->Set("dsareatecnica", $resSet['dsareatecnica']);
    $objTbTreinamento->Set("nrcargahoraria", $resSet['nrcargahoraria']);
    $objTbTreinamento->Set("fltipo", $resSet['fltipo']);

    if(!isset($GLOBALS['_intTotalTreinamento'])){
      $GLOBALS['_intTotalTreinamento'] = $resSet['_inttotal'];
    }

    return $objTbTreinamento;
  }

  //--------------------------------------------------------------------------------------------------------//
  // Métodos de Manutenção do Objeto
  //--------------------------------------------------------------------------------------------------------//

  /**
   * Insere um registro na tabela TbTreinamento
   * @param $objTbTreinamento -> Objeto com os dados a serem inseridos
   * @return string[]
   */
  public function Insert($objTbTreinamento) {
    $dtbLink = new DtbServer();
    $fmt = new Format();

    $dsSql = "INSERT INTO
                shtreinamento.tbtreinamento(
                  idtreinamento,
                  dstitulo,
                  dsdescricao,
                  dsareatecnica,
                  nrcargahoraria,
                  fltipo
                )
              VALUES(
                (select nextval('shtreinamento.sqidtreinamento') as nextid),  
                '".$fmt->escSqlQuotes($objTbTreinamento->Get("dstitulo"))."',  
                '".$fmt->escSqlQuotes($objTbTreinamento->Get("dsdescricao"))."',  
                '".$fmt->escSqlQuotes($objTbTreinamento->Get("dsareatecnica"))."',  
                ".$fmt->NullBd($objTbTreinamento->Get("nrcargahoraria")).",  
                '".$fmt->NullBd($objTbTreinamento->Get("fltipo"))."' 
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
   * Insere um registro na tabela TbTreinamento
   * @param $objTbTreinamento -> Objeto com os dados a serem inseridos
   * @return string[]
   */
  public function InsertWithId($objTbTreinamento) {
    $dtbLink = new DtbServer();
    $fmt = new Format();

    $dsSql = "INSERT INTO
                shtreinamento.tbtreinamento(
                  idtreinamento,
                  dstitulo,
                  dsdescricao,
                  dsareatecnica,
                  nrcargahoraria,
                  fltipo
                )
              VALUES(
                ".$fmt->NullBd($objTbTreinamento->Get("idtreinamento")).",  
                ".$fmt->escSqlQuotes($objTbTreinamento->Get("dstitulo")).",  
                ".$fmt->escSqlQuotes($objTbTreinamento->Get("dsdescricao")).",  
                ".$fmt->escSqlQuotes($objTbTreinamento->Get("dsareatecnica")).",  
                ".$fmt->NullBd($objTbTreinamento->Get("nrcargahoraria")).",  
                ".$fmt->NullBd($objTbTreinamento->Get("fltipo"))." 
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
   * Altera um registro na tabela TbTreinamento
   * @param TbTreinamento $objTbTreinamento -> Objeto com os dados a serem alterados
   * @return string[]
   */
  public function Update($objTbTreinamento) {
    $dtbLink = new DtbServer();
    $fmt = new Format();

    $dsSql = "UPDATE
                shtreinamento.tbtreinamento
              SET
                dstitulo = '".$fmt->escSqlQuotes($objTbTreinamento->Get("dstitulo"))."',  
                dsdescricao = '".$fmt->escSqlQuotes($objTbTreinamento->Get("dsdescricao"))."',  
                dsareatecnica = '".$fmt->escSqlQuotes($objTbTreinamento->Get("dsareatecnica"))."',  
                nrcargahoraria = ".$fmt->NullBd($objTbTreinamento->Get("nrcargahoraria")).",  
                fltipo = '".$fmt->NullBd($objTbTreinamento->Get("fltipo"))."' 
              WHERE
                idtreinamento = ".$objTbTreinamento->Get("idtreinamento").";";
    if(!$dtbLink->ExecSql($dsSql)) {
      $arrMsg = $dtbLink->getMessage();
    }
    else {
      $arrMsg['dsMsg'] = "ok";
    }
    return $arrMsg;
  }

  /**
   * Elimina registro na tabela TbTreinamento
   * @param TbTreinamento $objTbTreinamento -> Objeto com os dados a serem eliminados
   * @return string[]
   */
  public function Delete($objTbTreinamento) {
    $dtbLink = new DtbServer();

    $dsSql = "DELETE FROM
                shtreinamento.tbtreinamento
              WHERE
                idtreinamento = ".$objTbTreinamento->Get("idtreinamento").";";

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
   * @param $idTreinamento -> Chave a ser buscada
   * @return TbTreinamento
   */
  public static function LoadByIdTreinamento($idTreinamento) {
    $dtbLink = new DtbServer();
    $fmt = new Format();
    $objTbTreinamento = new TbTreinamento();

    $dsSql = "SELECT
                *
              FROM
                shtreinamento.tbtreinamento tr
              WHERE
                idtreinamento = {$idTreinamento};";

    if(!$dtbLink->Query($dsSql)) {
      return $fmt->RemoveQuebraLinha($dtbLink->getMessage()['dsMsg']."<br>");
    }
    else {
      $resSet = $dtbLink->FetchArray();
      $objTbTreinamento = $objTbTreinamento->LoadObject($resSet);
    }
    return $objTbTreinamento;
  }

  /**
   * Busca os dados da tabela com parâmetros de condição e ordenação
   * @param $strCondicao -> Condição da pesquisa
   * @param $strOrdenacao -> Ordenação da pesquisa
   * @return TbTreinamento[]
   */
  public static function ListByCondicao($strCondicao, $strOrdenacao) {
    $dtbLink = new DtbServer();
    $fmt = new Format();
    $objTbTreinamento = new TbTreinamento();

    $dsSql = "SELECT
                *,
                count(*) over() as _inttotal 
              FROM
                shtreinamento.tbtreinamento tr
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
        $aroTbTreinamento[] = $objTbTreinamento->LoadObject($resSet);
      }
    }
    return $aroTbTreinamento;
  }

  /**
   * Retorna o próximo id da sequência
   * @return int
   */
  public static function GetNextId(){
    $dtbLink = new DtbServer();
    $fmt = new Format();

    $dsSql = "SELECT nextval('shtreinamento.sqidtreinamento') as nextid";

    if(!$dtbLink->Query($dsSql)) {
      return $fmt->RemoveQuebraLinha($dtbLink->getMessage()['dsMsg']."<br>");
    }
    else {
      $resSet = $dtbLink->FetchArray();
      return $resSet['nextid'];
    }
  }
}