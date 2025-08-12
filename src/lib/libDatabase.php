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
  //Método que abre a conexão com o Banco de Dados
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
  //Método que efetua a conexão com o Banco de Dados
  //-----------------------------------------------------------------------------------------------------------------------//
  public function Connect(){
    $this->lnkClient = pg_connect("host=".$this->strDbHostClient." port=5432 dbname=dbsisgov user=ussisgov password=".$this->strDbPassClient."");
  }
  //-----------------------------------------------------------------------------------------------------------------------//

  //-----------------------------------------------------------------------------------------------------------------------//
  //Método que executa uma consulta via Query Sql
  //-----------------------------------------------------------------------------------------------------------------------//
  public function Query($strSql){
    $this->strQueryClient = $strSql;
    $this->qryClient = @pg_query($this->lnkClient,$this->strQueryClient);
    return $this->qryClient;
  }
  //-----------------------------------------------------------------------------------------------------------------------//

  //-----------------------------------------------------------------------------------------------------------------------//
  //Método que retorna o resultado de uma consulta em um Array
  //-----------------------------------------------------------------------------------------------------------------------//
  public function FetchArray(){
    return pg_fetch_array($this->qryClient);
  }
  //-----------------------------------------------------------------------------------------------------------------------//

  //-----------------------------------------------------------------------------------------------------------------------//
  //Método que executa uma Query Sql de Manutenção
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
  //Método que Abre uma Tranzação no Banco de Dados
  //-----------------------------------------------------------------------------------------------------------------------//
  public function Begin(){
    $this->qryClient = pg_query($this->lnkClient,"begin;");
  }
  //-----------------------------------------------------------------------------------------------------------------------//

  //-----------------------------------------------------------------------------------------------------------------------//
  //Método que Confirma uma Tranzação no Banco de Dados
  //-----------------------------------------------------------------------------------------------------------------------//
  public function Commit(){
    $this->qryClient = pg_query($this->lnkClient,"commit;");
  }
  //-----------------------------------------------------------------------------------------------------------------------//

  //-----------------------------------------------------------------------------------------------------------------------//
  //Método que Cancela uma Tranzação no Banco de Dados
  //-----------------------------------------------------------------------------------------------------------------------//
  public function Rollback(){
    $this->qryClient = pg_query($this->lnkClient,"rollback;");
  }
  //-----------------------------------------------------------------------------------------------------------------------//

  //-----------------------------------------------------------------------------------------------------------------------//
  //Metodo Responsável pelo Retorno da Mensagem de Erro de Acordo com o Código do Mesmo
  //-----------------------------------------------------------------------------------------------------------------------//
  function Message(){
    switch ($this->qryErrorCodeClient) {
      case '23505' :
        return 'Já existe um registro cadastrado com os dados informados!<br>';
        break;
      case '23503' :
        return 'Não é possível excluir o registro selecionado pois o mesmos está sendo utilizando em outros cadastros!<br>Erro:'.pg_last_error().'<br>';
        break;
      case '3F000' :
        return 'Schema não encontrado no banco de dados!<br>Erro:'.pg_last_error().'<br>';
        break;
      case '42P01' :
        return 'Erro de Sistema nº '.$this->qryErrorCodeClient.' tabela não existe no banco de dados. <br>Erro:'.pg_last_error().'<br>';
        break;
      case '42703' :
        return 'Erro de Sistema nº '.$this->qryErrorCodeClient.' coluna não existe no banco de dados. <br>Erro:'.pg_last_error().'<br>';
        break;
      case '42601' :
        return 'Erro de Sql nº '.$this->qryErrorCodeClient.' sintaxe do comando incorreta. <br>Erro:'.pg_last_error().'<br>';
        break;
      default:
        return 'Erro não catalogado: '.$this->qryErrorCodeClient.' <br>Erro:'.pg_last_error().'<br>Sql:'.$this->strQueryClient.'<br>';
        break;
    }
  }

  //-----------------------------------------------------------------------------------------------------------------------//
  //Metodo Responsável pelo Retorno da Mensagem de Erro de Acordo com o Código do Mesmo
  //-----------------------------------------------------------------------------------------------------------------------//
  /**
  * Função para retorno erro de Banco
  * @author Marcos Frare
  */
  public function getMessage(){
    $arrMsg = array();
    switch($this->qryErrorCodeClient){
      case '23505':{
        $arrMsg['flTipo'] = 'A';
        $arrMsg['dsMsg'] = '&raquo; Já existe um registro cadastrado com os dados informados!<br>';
        break;
      }
      case '23503':{
        $arrMsg['flTipo'] = 'A';
        $arrMsg['dsMsg'] = '&raquo; Não é possível excluir o registro selecionado pois o mesmos está sendo utilizando em outros cadastros!<br>Erro:'.pg_last_error().'<br>';
        break;
      }
      case '3F000':{
        $arrMsg['flTipo'] = 'E';
        $arrMsg['dsMsg'] = 'Schema não encontrado no banco de dados!<br>'.pg_last_error().'<br>'.$this->strQueryClient.'<br>';
        break;
      }
      case '42P01':{
        $arrMsg['flTipo'] = 'E';
        $arrMsg['dsMsg'] = 'Erro de Sistema nº '.$this->qryErrorCodeClient.' tabela não existe no banco de dados. <br>'.pg_last_error().'<br>'.$this->strQueryClient.'<br>';
        break;
      }
      case '42703':{
        $arrMsg['flTipo'] = 'E';
        $arrMsg['dsMsg'] = 'Erro de Sistema nº '.$this->qryErrorCodeClient.' coluna não existe no banco de dados. <br>'.pg_last_error().'<br>'.$this->strQueryClient.'<br>';
        break;
      }
      case '42601':{
        $arrMsg['flTipo'] = 'E';
        $arrMsg['dsMsg'] = 'Erro de Sql nº '.$this->qryErrorCodeClient.' sintaxe do comando incorreta. <br>'.pg_last_error().'<br>'.$this->strQueryClient.'<br>';
        break;
      }
      default:{
        $arrMsg['flTipo'] = 'E';
        $arrMsg['dsMsg'] = 'Erro não catalogado: '.$this->qryErrorCodeClient.' <br>'.pg_last_error().'<br>Sql:'.$this->strQueryClient.'<br>';
        break;
      }
    }
    
    return $arrMsg;
  }
  //-----------------------------------------------------------------------------------------------------------------------//
}