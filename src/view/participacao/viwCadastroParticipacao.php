<?php
@header("Content-Type: text/html; charset=ISO-8859-1", true);
?>

<script>
  $(function () {
    //---------------------------------------------------------------------------------//
    // Instancia dos campos
    //---------------------------------------------------------------------------------//
    $("#frmCadastroParticipacao #idTreinamento").kendoDropDownList({
      dataTextField: "dstitulo",
      dataValueField: "idtreinamento",
      filter: "contains",
      dataSource: {
        transport: {
          read: {
            url: "controller/treinamento/ctrTreinamento.php?action=ListTreinamento",
            dataType: "JSON",
            type: "GET"
          },
        },
        schema: {
          data: "jsnTreinamento"
        },
      },
      value: "<?php echo $objTbParticipacao->Get("idtreinamento") ?>",
    });

    $("#frmCadastroParticipacao #idColaborador").kendoDropDownList({
      dataTextField: "nmcolaborador",
      dataValueField: "idcolaborador",
      filter: "contains",
      dataSource: {
        transport: {
          read: {
            url: "controller/colaborador/ctrColaborador.php?action=ListColaborador",
            dataType: "JSON",
            type: "GET"
          },
        },
        schema: {
          data: "jsnColaborador"
        },
      },
      value: "<?php echo $objTbParticipacao->Get("idcolaborador") ?>",
    })
    //---------------------------------------------------------------------------------//

    //---------------------------------------------------------------------------------//
    // Instancia da barra de ações
    //---------------------------------------------------------------------------------//
    $("#frmCadastroParticipacao #BarAcoes").kendoToolBar({
      items: [
        { type: 'spacer' },
        {
          type: "buttonGroup",
          buttons: [
            {
              id: "BtnGravar",
              text: "Gravar",
              spriteCssClass: "k-pg-icon k-i-l1-c5",
              click: function () {
                kendo.ui.progress($("#frmCadastroParticipacao"), true);

                $.post(
                  "controller/participacao/ctrParticipacao.php?action=gravar",
                  $("#frmCadastroParticipacao").serialize(),
                  function (response) {
                    Message(response.flDisplay, response.flTipo, response.dsMsg);

                    if (response.flTipo == "S") {
                      $("#frmConsultaParticipacao #BtnPesquisar").click();

                      $("#frmCadastroParticipacao #BtnLimpar").click();
                    }

                    kendo.ui.progress($("#frmCadastroParticipacao"), false);
                  },
                  "json"
                )
              }
            },
            {
              id: "BtnExcluir",
              text: "Excluir",
              spriteCssClass: "k-pg-icon k-i-l1-c7",
              enable: false,
              click: function () {
                kendo.ui.progress($("#frmCadastroParticipacao"), true);

                $.post(
                  "controller/participacao/ctrParticipacao.php?action=excluir",
                  $("#frmCadastroParticipacao").serialize(),
                  function (response) {
                    Message(response.flDisplay, response.flTipo, response.dsMsg);

                    if (response.flTipo == "S") {
                      $("#frmConsultaParticipacao #BtnPesquisar").click();

                      $("#frmCadastroParticipacao #BtnLimpar").click();
                    }

                    kendo.ui.progress($("#frmCadastroParticipacao"), false);
                  },
                  "json"
                );
              }
            },
            {
              id: "BtnLimpar",
              text: "Limpar",
              spriteCssClass: "k-pg-icon k-i-l1-c6",
              click: function () {
                $("#WinCadastroParticipacao").data("kendoWindow").refresh({
                  url: "controller/participacao/ctrParticipacao.php?action=incluir"
                });
              }
            },
            {
              id: "BtnFechar",
              text: "Fechar",
              spriteCssClass: "k-pg-icon k-i-l1-c4",
              click: function () {
                $("#WinCadastroParticipacao").data("kendoWindow").close();
              }
            }
          ]
        }
      ]
    });
    //---------------------------------------------------------------------------------//

    //---------------------------------------------------------------------------------//
    // Demais ações de inicialização dos componentes
    //---------------------------------------------------------------------------------//

    if ($("#frmCadastroParticipacao #idParticipacao").val() != "") {
      SetAccess("T", "#frmCadastroParticipacao #BarAcoes", "#BtnExcluir", true)
    }

    $("#WinCadastroParticipacao").data("kendoWindow").center().open();
    //---------------------------------------------------------------------------------//
  })
</script>

<form id="frmCadastroParticipacao">
  <div class="k-form">
    <table width=" 100%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td style="width: 120px; text-align: right;">Id:</td>
        <td>
          <input class="k-textbox k-input-disabled" readonly style="width: 60px;" type="text" id="idParticipacao"
            name="idParticipacao" class="k-input-disabled k-textbox"
            value="<?php echo $objTbParticipacao->Get("idparticipacao") ?>">
          <label for="idParticipacao" class="screenreader">Id</label>
        </td>
      </tr>
    </table>

    <table width="100%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td class="k-required" style="width: 120px; text-align: right;">Treinamento:</td>
        <td>
          <select name="idTreinamento" id="idTreinamento" style="width: 300px">
          </select>
          <label for="idTreinamento" class="screenreader">Título</label>
        </td>
      </tr>
    </table>

    <table width="100%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td class="k-required" style="width: 120px; text-align: right;">Colaborador:</td>
        <td>
          <select name="idColaborador" id="idColaborador" style="width: 300px"></select>
          <label for="idColaborador" class="screenreader">Título</label>
        </td>
      </tr>
    </table>

    <div id="BarAcoes" style="text-align: right;height: 28px; position: relative"></div>
  </div>
</form>