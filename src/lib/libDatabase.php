<?php

class DtbServer {
  var $lnkClient;
  var $strQueryClient;
  var $qryClient;
  var $qryErrorCodeClient;
  var $strDbUserClient;
  var $strDbPasswordClient;
  var $strFlMonitora;
  var $strDbHostClient;
  var $strDbPassClient;

  //-----------------------------------------------------------------------------------------------------------------------//
  //M�todo que abre a conex�o com o Banco de Dados
  //-----------------------------------------------------------------------------------------------------------------------//
  public function __construct(){      
    $this->lnkClient = null;
    $this->qryClient = null;
    $this->strQueryClient = null;
    $this->strFlMonitora = 'S';
    $this->strDbHostClient = '192.168.2.11';
    $this->strDbPassClient = 'pgdesenv';

    $this->Connect();
  }
  //-----------------------------------------------------------------------------------------------------------------------//

  //-----------------------------------------------------------------------------------------------------------------------//
  //M�todo que efetua a conex�o com o Banco de Dados
  //-----------------------------------------------------------------------------------------------------------------------//
  public function Connect(){
    $this->lnkClient = pg_connect("host=".$this->strDbHostClient." port=5432 dbname=dbsisgov user=ussisgov password=".$this->strDbPassClient."");
  }
  //-----------------------------------------------------------------------------------------------------------------------//

  //-----------------------------------------------------------------------------------------------------------------------//
  //M�todo que executa uma consulta via Query Sql
  //-----------------------------------------------------------------------------------------------------------------------//
  public function Query($strSql){
    $this->strQueryClient = $strSql;
    $this->qryClient = @pg_query($this->lnkClient,$this->strQueryClient);
    return $this->qryClient;
  }
  //-----------------------------------------------------------------------------------------------------------------------//

  //-----------------------------------------------------------------------------------------------------------------------//
  //M�todo que retorna o resultado de uma consulta em um Array
  //-----------------------------------------------------------------------------------------------------------------------//
  public function FetchArray(){
    return pg_fetch_array($this->qryClient);
  }
  //-----------------------------------------------------------------------------------------------------------------------//

  //-----------------------------------------------------------------------------------------------------------------------//
  //M�todo que executa uma Query Sql de Manuten��o
  //-----------------------------------------------------------------------------------------------------------------------//
  public function ExecSql($strSql){
    $this->strQueryClient = $strSql;
    $this->qryClient = pg_send_query($this->lnkClient, $this->strQueryClient);
    $qryClientStatus = pg_get_result($this->lnkClient);

    $this->qryErrorCodeClient = pg_result_error_field($qryClientStatus, PGSQL_DIAG_SQLSTATE);

    if ($this->qryErrorCodeClient != null){
      return false;
    }
    else{
      if ($this->strFlMonitora == 'S') {
        $objDtbLog = new DtbLog();
        $objDtbLog->SaveLog($this->strQueryClient);
      }
      return true;
    }
  }
  //-----------------------------------------------------------------------------------------------------------------------//

  //-----------------------------------------------------------------------------------------------------------------------//
  //M�todo que Abre uma Tranza��o no Banco de Dados
  //-----------------------------------------------------------------------------------------------------------------------//
  public function Begin(){
    $this->qryClient = pg_query($this->lnkClient,"begin;");
  }
  //-----------------------------------------------------------------------------------------------------------------------//

  //-----------------------------------------------------------------------------------------------------------------------//
  //M�todo que Confirma uma Tranza��o no Banco de Dados
  //-----------------------------------------------------------------------------------------------------------------------//
  public function Commit(){
    $this->qryClient = pg_query($this->lnkClient,"commit;");
  }
  //-----------------------------------------------------------------------------------------------------------------------//

  //-----------------------------------------------------------------------------------------------------------------------//
  //M�todo que Cancela uma Tranza��o no Banco de Dados
  //-----------------------------------------------------------------------------------------------------------------------//
  public function Rollback(){
    $this->qryClient = pg_query($this->lnkClient,"rollback;");
  }
  //-----------------------------------------------------------------------------------------------------------------------//

  //-----------------------------------------------------------------------------------------------------------------------//
  //Metodo Respons�vel pelo Retorno da Mensagem de Erro de Acordo com o C�digo do Mesmo
  //-----------------------------------------------------------------------------------------------------------------------//
  function Message(){
    switch ($this->qryErrorCodeClient) {
      case '23505' :
        return 'J� existe um registro cadastrado com os dados informados!<br>';
        break;
      case '23503' :
        return 'N�o � poss�vel excluir o registro selecionado pois o mesmos est� sendo utilizando em outros cadastros!<br>Erro:'.pg_last_error().'<br>';
        break;
      case '3F000' :
        return 'Schema n�o encontrado no banco de dados!<br>Erro:'.pg_last_error().'<br>';
        break;
      case '42P01' :
        return 'Erro de Sistema n� '.$this->qryErrorCodeClient.' tabela n�o existe no banco de dados. <br>Erro:'.pg_last_error().'<br>';
        break;
      case '42703' :
        return 'Erro de Sistema n� '.$this->qryErrorCodeClient.' coluna n�o existe no banco de dados. <br>Erro:'.pg_last_error().'<br>';
        break;
      case '42601' :
        return 'Erro de Sql n� '.$this->qryErrorCodeClient.' sintaxe do comando incorreta. <br>Erro:'.pg_last_error().'<br>';
        break;
      default:
        return 'Erro n�o catalogado: '.$this->qryErrorCodeClient.' <br>Erro:'.pg_last_error().'<br>Sql:'.$this->strQueryClient.'<br>';
        break;
    }
  }

  //-----------------------------------------------------------------------------------------------------------------------//
  //Metodo Respons�vel pelo Retorno da Mensagem de Erro de Acordo com o C�digo do Mesmo
  //-----------------------------------------------------------------------------------------------------------------------//
  /**
  * Fun��o para retorno erro de Banco
  * @author Marcos Frare
  */
  public function getMessage(){
    $arrMsg = array();
    switch($this->qryErrorCodeClient){
      case '23505':{
        $arrMsg['flTipo'] = 'A';
        $arrMsg['dsMsg'] = '&raquo; J� existe um registro cadastrado com os dados informados!<br>';
        break;
      }
      case '23503':{
        $arrMsg['flTipo'] = 'A';
        $arrMsg['dsMsg'] = '&raquo; N�o � poss�vel excluir o registro selecionado pois o mesmos est� sendo utilizando em outros cadastros!<br>Erro:'.pg_last_error().'<br>';
        break;
      }
      case '3F000':{
        $arrMsg['flTipo'] = 'E';
        $arrMsg['dsMsg'] = 'Schema n�o encontrado no banco de dados!<br>'.pg_last_error().'<br>'.$this->strQueryClient.'<br>';
        break;
      }
      case '42P01':{
        $arrMsg['flTipo'] = 'E';
        $arrMsg['dsMsg'] = 'Erro de Sistema n� '.$this->qryErrorCodeClient.' tabela n�o existe no banco de dados. <br>'.pg_last_error().'<br>'.$this->strQueryClient.'<br>';
        break;
      }
      case '42703':{
        $arrMsg['flTipo'] = 'E';
        $arrMsg['dsMsg'] = 'Erro de Sistema n� '.$this->qryErrorCodeClient.' coluna n�o existe no banco de dados. <br>'.pg_last_error().'<br>'.$this->strQueryClient.'<br>';
        break;
      }
      case '42601':{
        $arrMsg['flTipo'] = 'E';
        $arrMsg['dsMsg'] = 'Erro de Sql n� '.$this->qryErrorCodeClient.' sintaxe do comando incorreta. <br>'.pg_last_error().'<br>'.$this->strQueryClient.'<br>';
        break;
      }
      default:{
        $arrMsg['flTipo'] = 'E';
        $arrMsg['dsMsg'] = 'Erro n�o catalogado: '.$this->qryErrorCodeClient.' <br>'.pg_last_error().'<br>Sql:'.$this->strQueryClient.'<br>';
        break;
      }
    }
    
    return $arrMsg;
  }
  //-----------------------------------------------------------------------------------------------------------------------//
}