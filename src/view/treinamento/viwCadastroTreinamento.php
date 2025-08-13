<?php
@header("Content-Type: text/html; charset=ISO-8859-1", true);
?>

<script>
  $(function () {
		//---------------------------------------------------------------------------------//
		// Instancia dos campos
		//---------------------------------------------------------------------------------//
		$("#frmCadastroTreinamento #nrCargaHoraria").kendoNumericTextBox({
			decimals: 2,
			min: 0,
			format: "#"
		});

		$("#frmCadastroTreinamento #flTipo").kendoDropDownList()
		//---------------------------------------------------------------------------------//


		//---------------------------------------------------------------------------------//
		// Instancia da barra de ações
		//---------------------------------------------------------------------------------//
		$("#frmCadastroTreinamento #BarAcoes").kendoToolBar({
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
								kendo.ui.progress($("#frmCadastroTreinamento"), true);

								$.post(
									"controller/treinamento/ctrTreinamento.php?action=gravar",
									$("#frmCadastroTreinamento").serialize(),
									function(response) {
										Message(response.flDisplay, response.flTipo, response.dsMsg);

										if(response.flTipo == "S") {
											$("#frmConsultaTreinamento #BtnPesquisar").click();

											$("#frmCadastroTreinamento #BtnLimpar").click();
										}

										kendo.ui.progress($("#frmCadastroTreinamento"), false);
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
								kendo.ui.progress($("#frmCadastroTreinamento"), true);

								$.post(
									"controller/treinamento/ctrTreinamento.php?action=excluir",
									$("#frmCadastroTreinamento").serialize(),
									function(response) {
										Message(response.flDisplay, response.flTipo, response.dsMsg);

										if(response.flTipo == "S") {
											$("#frmConsultaTreinamento #BtnPesquisar").click();

											$("#frmCadastroTreinamento #BtnLimpar").click();
										}

										kendo.ui.progress($("#frmCadastroTreinamento"), false);
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
								$("#WinCadastroTreinamento").data("kendoWindow").refresh({
									url: "controller/treinamento/ctrTreinamento.php?action=incluir"
								});
							}
						},
						{
							id: "BtnFechar",
							text: "Fechar",
							spriteCssClass: "k-pg-icon k-i-l1-c4",
							click: function () {
								$("#WinCadastroTreinamento").data("kendoWindow").close();
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

		if($("#frmCadastroTreinamento #idTreinamento").val() != "") {
			SetAccess("T", "#frmCadastroTreinamento #BarAcoes", "#BtnExcluir", true)
		}

		$("#WinCadastroTreinamento").data("kendoWindow").center().open();
		//---------------------------------------------------------------------------------//
  })
</script>

<form id="frmCadastroTreinamento">
	<div class="k-form">
		<table width=" 100%" border="0" cellspacing="2" cellpadding="0">
			<tr>
				<td style="width: 120px; text-align: right;">Id:</td>
				<td>
					<input 
						readonly
						style="width: 60px;" 
						type="text" 
						id="idTreinamento" 
						name="idTreinamento"
						class="k-input-disabled k-textbox" 
						value="<?php echo $objTbTreinamento->Get("idtreinamento") ?>"
					>
					<label for="idTreinamento" class="screenreader">Id</label>
				</td>
			</tr>
		</table>

		<table width="100%" border="0" cellspacing="2" cellpadding="0">
			<tr>
				<td class="k-required" style="width: 120px; text-align: right;">Título:</td>
				<td>
					<input 
						class="k-textbox" 
						style="width: 600px;" 
						type="text" 
						id="dsTitulo" 
						name="dsTitulo"
						value="<?php echo $objTbTreinamento->Get("dstitulo") ?>"
						>
					<label for="dsTitulo" class="screenreader">Título</label>
				</td>
			</tr>
		</table>

		<table width=" 100%" border="0" cellspacing="2" cellpadding="0">
			<tr>
				<td style="width: 120px; text-align: right;">Descricao:</td>
				<td>
					<input 
						class="k-textbox" 
						style="width: 600px;" 
						type="text" 
						id="dsDescricao" 
						name="dsDescricao"
						value="<?php echo $objTbTreinamento->Get("dsdescricao") ?>"
					>
					<label for="dsDescricao" class="screenreader">Descricao</label>
				</td>
			</tr>
		</table>

		<table width=" 100%" border="0" cellspacing="2" cellpadding="0">
			<tr>
				<td class="k-required" style="width: 120px; text-align: right;">Área Técnica:</td>
				<td>
					<input 
						class="k-textbox" 
						style="width: 150px;" 
						type="text" 
						id="dsAreaTecnica" 
						name="dsAreaTecnica"
						value="<?php echo $objTbTreinamento->Get("dsareatecnica") ?>"
					>
					<label for="dsAreaTecnica" class="screenreader">Área Técnica</label>
				</td>

				<td class="k-required" style="width: 244px; text-align: right;">Carga Horária:</td>
				<td>
					<input 
						style="width: 130px;" 
						id="nrCargaHoraria" 
						name="nrCargaHoraria"
						value="<?php echo $objTbTreinamento->Get("nrcargahoraria") ?>"
					>
					<label for="nrCargaHoraria" class="screenreader">Carga Horária</label>
				</td>
			</tr>
		</table>

		<table width=" 100%" border="0" cellspacing="2" cellpadding="0">
			<tr>
				<td class="k-required"  style="width: 120px; text-align: right;">Tipo:</td>
				<td>
					<select style="width: 150px;" id="flTipo" name="flTipo">
						<option value=""></option>
						<option 
						value="T" 
						<?php echo $objTbTreinamento->Get("fltipo") == "T" ? "selected" : "" ?>
						>
						Técnico
						</option>
						<option 
							value="C" 
							<?php echo $objTbTreinamento->Get("fltipo") == "C" ? "selected" : "" ?>
						>
							Comportamental
						</option>
					</select>
					<label for="flTipo" class="screenreader">Tipo</label>
				</td>
			</tr>
		</table>

		<div id="BarAcoes" style="text-align: right;height: 28px; position: relative"></div>
	</div>
</form>