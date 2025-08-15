<?php

class TbParticipacao
{
  //--------------------------------------------------------------------------------------------------------//
  // Métodos de Definição da Classe [CLASS]
  //--------------------------------------------------------------------------------------------------------//  

  // Propriedades Persistentes
  private $idparticipacao;
  private $idcolaborador;
  private $idtreinamento;

  // Propriedades Abstratas
  private $dtbLink;
  private $dstitulo;
  private $nmcolaborador;

  /**
   * Metodo Construct para Limpeza do Objeto 
   */
  public function __construct()
  {
    $this->idparticipacao = "";
    $this->idcolaborador = "";
    $this->idtreinamento = "";
  }

  /**
   * Método Set para Carga do Objeto
   */
  public function Set($prpTbParticipacao, $valTbParticipacao)
  {
    $this->$prpTbParticipacao = $valTbParticipacao;
  }

  /**
   * Método Get para Busca do Objeto
   */
  public function Get($prpTbParticipacao)
  {
    return $this->$prpTbParticipacao;
  }

  public function SetDtbLink($dtbLink)
  {
    $this->dtbLink = $dtbLink;
  }

  /**
   * Carrega o Objeto com os dados do resultSet de uma query
   * @param $resSet -> ResultSet da Query
   * @return TbParticipacao
   */
  public function LoadObject($resSet)
  {
    $objTbParticipacao = new TbParticipacao();

    $objTbParticipacao->Set("idparticipacao", $resSet['idparticipacao']);
    $objTbParticipacao->Set("idtreinamento", $resSet['idtreinamento']);
    $objTbParticipacao->Set("idcolaborador", $resSet['idcolaborador']);
    $objTbParticipacao->Set("nmcolaborador", $resSet['nmcolaborador']);
    $objTbParticipacao->Set("dstitulo", $resSet['dstitulo']);

    if (!isset($GLOBALS['_intTotalParticipacao'])) {
      $GLOBALS['_intTotalParticipacao'] = $resSet['_inttotal'];
    }

    return $objTbParticipacao;
  }

  /**
   * Herança da tabela TbColaborador
   * @return TbColaborador
   */
  public function GetObjTbColaborador()
  {
    if (!$this->objTbColaborador) {
      $this->objTbColaborador = new TbColaborador();
      if ($this->Get("idcolaborador") != "") {
        $this->objTbColaborador = TbColaborador::LoadByIdColaborador($this->Get("idcolaborador"));
      }
    }
    return $this->objTbColaborador;
  }

  /**
   * Herança da tabela TbTreinamento
   * @return TbTreinamento
   */
  public function GetObjTbTreinamento()
  {
    if (!$this->objTbTreinamento) {
      $this->objTbTreinamento = new TbTreinamento();
      if ($this->Get("idtreinamento") != "") {
        $this->objTbTreinamento = TbTreinamento::LoadByIdTreinamento($this->Get("idtreinamento"));
      }
    }
    return $this->objTbTreinamento;
  }

  //--------------------------------------------------------------------------------------------------------//
  // Métodos de Manutenção do Objeto
  //--------------------------------------------------------------------------------------------------------//

  /**
   * Insere um registro na tabela TbParticipacao
   * @param $objTbParticipacao -> Objeto com os dados a serem inseridos
   * @return string[]
   */
  public function Insert($objTbParticipacao)
  {
    if (!$this->dtbLink) {
      $this->dtbLink = new DtbServer();
    }
    $fmt = new Format();

    $dsSql = "INSERT INTO
                shtreinamento.tbparticipacao(
                  idparticipacao,
                  idtreinamento,
                  idcolaborador
                )
              VALUES(
                (select nextval('shtreinamento.sqidparticipacao') as nextid),  
                " . $fmt->NullBd($objTbParticipacao->Get("idtreinamento")) . ",  
                " . $fmt->NullBd($objTbParticipacao->Get("idcolaborador")) . " 
              );";

    if (!$this->dtbLink->ExecSql($dsSql)) {
      $arrMsg = $this->dtbLink->getMessage();
    } else {
      $arrMsg['dsMsg'] = "ok";
    }
    return $arrMsg;
  }

  /**
   * Insere um registro na tabela TbParticipacao
   * @param $objTbParticipacao -> Objeto com os dados a serem inseridos
   * @return string[]
   */
  public function InsertWithId($objTbParticipacao)
  {
    if (!$this->dtbLink) {
      $this->dtbLink = new DtbServer();
    }
    $fmt = new Format();

    $dsSql = "INSERT INTO
                shtreinamento.tbparticipacao(
                  idparticipacao,
                  idtreinamento,
                  idcolaborador
                )
              VALUES(
                " . $fmt->NullBd($objTbParticipacao->Get("idparticipacao")) . ",  
                " . $fmt->NullBd($objTbParticipacao->Get("idtreinamento")) . ",  
                " . $fmt->NullBd($objTbParticipacao->Get("idcolaborador")) . " 
              );";

    if (!$this->dtbLink->ExecSql($dsSql)) {
      $arrMsg = $this->dtbLink->getMessage();
    } else {
      $arrMsg['dsMsg'] = "ok";
    }
    return $arrMsg;
  }

  /**
   * Altera um registro na tabela TbParticipacao
   * @param TbParticipacao $objTbParticipacao -> Objeto com os dados a serem alterados
   * @return string[]
   */
  public function Update($objTbParticipacao)
  {
    if (!$this->dtbLink) {
      $this->dtbLink = new DtbServer();
    }
    $fmt = new Format();

    $dsSql = "UPDATE
                shtreinamento.tbparticipacao
              SET
                idtreinamento = " . $fmt->NullBd($objTbParticipacao->Get("idtreinamento")) . ",  
                idcolaborador = " . $fmt->NullBd($objTbParticipacao->Get("idcolaborador")) . "   
              WHERE
                idparticipacao = " . $objTbParticipacao->Get("idparticipacao") . ";";

    if (!$this->dtbLink->ExecSql($dsSql)) {
      $arrMsg = $this->dtbLink->getMessage();
    } else {
      $arrMsg['dsMsg'] = "ok";
    }
    return $arrMsg;
  }

  /**
   * Elimina registro na tabela TbParticipacao
   * @param TbParticipacao $objTbParticipacao -> Objeto com os dados a serem eliminados
   * @return string[]
   */
  public function Delete($objTbParticipacao)
  {
    if (!$this->dtbLink) {
      $this->dtbLink = new DtbServer();
    }

    $dsSql = "DELETE FROM
                shtreinamento.tbparticipacao
              WHERE
                idparticipacao = " . $objTbParticipacao->Get("idparticipacao") . ";";

    if (!$this->dtbLink->ExecSql($dsSql)) {
      $arrMsg = $this->dtbLink->getMessage();
    } else {
      $arrMsg['dsMsg'] = "ok";
    }
    return $arrMsg;
  }

  //--------------------------------------------------------------------------------------------------------//
  // Métodos de Consulta do Objeto
  //--------------------------------------------------------------------------------------------------------//

  /**
   * Busca os dados na tabela pela condição da chave primária
   * @param $idParticipacao -> Chave a ser buscada
   * @return TbParticipacao
   */
  public static function LoadByIdParticipacao($idParticipacao)
  {
    $dtbLink = new DtbServer();
    $fmt = new Format();
    $objTbParticipacao = new TbParticipacao();

    $dsSql = "SELECT
                pa.*,
                tr.dstitulo,
                co.nmcolaborador
              FROM
                shtreinamento.tbparticipacao pa
              JOIN
                shtreinamento.tbtreinamento tr
              ON 
                pa.idtreinamento = tr.idtreinamento
              JOIN 
                shtreinamento.tbcolaborador co
              ON 
                co.idcolaborador = pa.idcolaborador
              WHERE
                idparticipacao = {$idParticipacao};";

    if (!$dtbLink->Query($dsSql)) {
      return $fmt->RemoveQuebraLinha($dtbLink->getMessage()['dsMsg'] . "<br>");
    } else {
      $resSet = $dtbLink->FetchArray();
      $objTbParticipacao = $objTbParticipacao->LoadObject($resSet);
    }
    return $objTbParticipacao;
  }

  /**
   * Busca os dados da tabela com parâmetros de condição e ordenação
   * @param $strCondicao -> Condição da pesquisa
   * @param $strOrdenacao -> Ordenação da pesquisa
   * @return TbParticipacao[]
   */
  public static function ListByCondicao($strCondicao, $strOrdenacao)
  {
    $dtbLink = new DtbServer();
    $fmt = new Format();
    $objTbParticipacao = new TbParticipacao();

    $dsSql = "SELECT
                pa.*,
                tr.dstitulo,
                co.nmcolaborador,
                COUNT(*) OVER() AS _inttotal
              FROM
                shtreinamento.tbparticipacao pa
              JOIN
                shtreinamento.tbtreinamento tr
              ON 
                pa.idtreinamento = tr.idtreinamento
              JOIN 
                shtreinamento.tbcolaborador co
              ON 
                co.idcolaborador = pa.idcolaborador
              WHERE
                1 = 1 ";

    if ($strCondicao != "") {
      $dsSql .= $strCondicao;
    }
    if ($strOrdenacao != "") {
      $dsSql .= " ORDER BY {$strOrdenacao}";
    }

    if (!$dtbLink->Query($dsSql)) {
      return $fmt->RemoveQuebraLinha($dtbLink->getMessage()['dsMsg'] . "<br>");
    } else {
      while ($resSet = $dtbLink->FetchArray()) {
        $aroTbParticipacao[] = $objTbParticipacao->LoadObject($resSet);
      }
    }
    return $aroTbParticipacao;
  }

  /**
   * Retorna o próximo id da sequência
   * @return int
   */
  public static function GetNextId()
  {
    $dtbLink = new DtbServer();
    $fmt = new Format();

    $dsSql = "SELECT nextval('shtreinamento.sqidparticipacao') as nextid";

    if (!$dtbLink->Query($dsSql)) {
      return $fmt->RemoveQuebraLinha($dtbLink->getMessage()['dsMsg'] . "<br>");
    } else {
      $resSet = $dtbLink->FetchArray();
      return $resSet['nextid'];
    }
  }
}