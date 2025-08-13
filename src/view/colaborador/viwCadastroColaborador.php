<?php
@header("Content-Type: text/html; charset=ISO-8859-1", true);
?>

<script>
  $(function () {
		//---------------------------------------------------------------------------------//
		// Instancia dos campos
		//---------------------------------------------------------------------------------//
		$("#frmCadastroColaborador #dtContratacao").kendoDatePicker({
      format: "dd/MM/yyyy"
    });
    $("#frmCadastroColaborador #dtContratacao").kendoMaskedTextBox({ 
      mask: "00/00/0000" 
    });
		//---------------------------------------------------------------------------------//


		//---------------------------------------------------------------------------------//
		// Instancia da barra de ações
		//---------------------------------------------------------------------------------//
		$("#frmCadastroColaborador #BarAcoes").kendoToolBar({
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
								kendo.ui.progress($("#frmCadastroColaborador"), true);

								$.post(
									"controller/colaborador/ctrColaborador.php?action=gravar",
									$("#frmCadastroColaborador").serialize(),
									function(response) {
										Message(response.flDisplay, response.flTipo, response.dsMsg);

										if(response.flTipo == "S") {
											$("#frmConsultaColaborador #BtnPesquisar").click();

											$("#frmCadastroColaborador #BtnLimpar").click();
										}

										kendo.ui.progress($("#frmCadastroColaborador"), false);
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
								kendo.ui.progress($("#frmCadastroColaborador"), true);

								$.post(
									"controller/colaborador/ctrColaborador.php?action=excluir",
									$("#frmCadastroColaborador").serialize(),
									function(response) {
										Message(response.flDisplay, response.flTipo, response.dsMsg);

										if(response.flTipo == "S") {
											$("#frmConsultaColaborador #BtnPesquisar").click();

											$("#frmCadastroColaborador #BtnLimpar").click();
										}

										kendo.ui.progress($("#frmCadastroColaborador"), false);
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
								$("#WinCadastroColaborador").data("kendoWindow").refresh({
									url: "controller/colaborador/ctrColaborador.php?action=incluir"
								});
							}
						},
						{
							id: "BtnFechar",
							text: "Fechar",
							spriteCssClass: "k-pg-icon k-i-l1-c4",
							click: function () {
								$("#WinCadastroColaborador").data("kendoWindow").close();
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

		if($("#frmCadastroColaborador #idColaborador").val() != "") {
			SetAccess("T", "#frmCadastroColaborador #BarAcoes", "#BtnExcluir", true)
		}

		$("#WinCadastroColaborador").data("kendoWindow").center().open();
		//---------------------------------------------------------------------------------//
  })
</script>

<form id="frmCadastroColaborador">
	<div class="k-form">
		<table width=" 100%" border="0" cellspacing="2" cellpadding="0">
			<tr>
				<td style="width: 120px; text-align: right;">Id:</td>
				<td>
					<input 
						readonly
						style="width: 60px;" 
						type="text" 
						id="idColaborador" 
						name="idColaborador"
						class="k-input-disabled k-textbox" 
						value="<?php echo $objTbColaborador->Get("idcolaborador") ?>"
					>
					<label for="idColaborador" class="screenreader">Id</label>
				</td>
			</tr>
		</table>

		<table width="100%" border="0" cellspacing="2" cellpadding="0">
			<tr>
				<td class="k-required" style="width: 120px; text-align: right;">Nome:</td>
				<td>
					<input 
						class="k-textbox" 
						style="width: 600px;" 
						type="text" 
						id="nmColaborador" 
						name="nmColaborador"
						value="<?php echo $objTbColaborador->Get("nmcolaborador") ?>"
						>
					<label for="nmColaborador" class="screenreader">Nome</label>
				</td>
			</tr>
		</table>

		<table width="100%" border="0" cellspacing="2" cellpadding="0">
			<tr>
				<td class="k-required" style="width: 120px; text-align: right;">E-mail:</td>
				<td>
					<input 
						class="k-textbox" 
						style="width: 600px;" 
						type="text" 
						id="dsEmail" 
						name="dsEmail"
						value="<?php echo $objTbColaborador->Get("dsemail") ?>"
						>
					<label for="dsEmail" class="screenreader">E-mail</label>
				</td>
			</tr>
		</table>
		
    <table width="100%" border="0" cellspacing="2" cellpadding="0">
			<tr>
				<td class="k-required" style="width: 120px; text-align: right;">Setor:</td>
				<td>
					<input 
						class="k-textbox" 
						style="width: 600px;" 
						type="text" 
						id="dsSetor" 
						name="dsSetor"
						value="<?php echo $objTbColaborador->Get("dsemail") ?>"
						>
					<label for="dsSetor" class="screenreader">Setor</label>
				</td>
			</tr>
		</table>
    
    <table width="100%" border="0" cellspacing="2" cellpadding="0">
			<tr>
				<td class="k-required" style="width: 120px; text-align: right;">Data de Contratação:</td>
				<td>
					<input
						style="width: 100px;" 
						type="text" 
						id="dtContratacao" 
						name="dtContratacao"
						value="<?php echo $objTbColaborador->Get("dtcontratacao") ?>"
						>
					<label for="dtContratacao" class="screenreader">Data de Contratação</label>
				</td>
			</tr>
		</table>

		<div id="BarAcoes" style="text-align: right;height: 28px; position: relative"></div>
	</div>
</form>