<?php
@header("Content-Type: text/html; charset=ISO-8859-1", true);
?>

<script>
	$(function () {
		//---------------------------------------------------------------------------------//
		// Instancia dos campos
		//---------------------------------------------------------------------------------//
		$("#frmMultiploCadastroParticipacao #arrIdColaborador").multipleSelect({
			placeholder: "Selecione os colaboradores",
			selectAllText: "Selecionar todos",
			allSelected: "Todos selecionados"
		});
		//---------------------------------------------------------------------------------//

		//---------------------------------------------------------------------------------//
		// Instancia da barra de ações
		//---------------------------------------------------------------------------------//
		$("#frmMultiploCadastroParticipacao #BarAcoes").kendoToolBar({
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
								kendo.ui.progress($("#frmMultiploCadastroParticipacao"), true);

								const arrIdColaborador = $("#frmMultiploCadastroParticipacao #arrIdColaborador").multipleSelect("getSelects");

								const idTreinamento = $("#frmMultiploCadastroParticipacao #idTreinamento").val();

								const payload = {
									idTreinamento,
									arrIdColaborador
								}

								$.post(
									"controller/participacao/ctrParticipacao.php?action=inserirMulti",
									payload,
									function (response) {
										Message(response.flDisplay, response.flTipo, response.dsMsg);

										if (response.flTipo == "S") {
											$("#frmConsultaParticipacao #BtnPesquisar").click();

											$("#frmMultiploCadastroParticipacao #BtnLimpar").click();
										}

										kendo.ui.progress($("#frmMultiploCadastroParticipacao"), false);
									},
									"json"
								)
							}
						},
						{
							id: "BtnLimpar",
							text: "Limpar",
							spriteCssClass: "k-pg-icon k-i-l1-c6",
							click: function () {
								$("#WinMultiploCadastroParticipacao").data("kendoWindow").refresh({
									url: "controller/participacao/ctrParticipacao.php?action=incluirMulti&idTreinamento=<?php echo $idTreinamento ?>"
								});
							}
						},
						{
							id: "BtnFechar",
							text: "Fechar",
							spriteCssClass: "k-pg-icon k-i-l1-c4",
							click: function () {
								$("#WinMultiploCadastroParticipacao").data("kendoWindow").close();
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

		$.post(
			"controller/colaborador/ctrColaborador.php?action=ListColaborador",
			function (response) {
				let strOptions = "";
				for (i = 0; i < response.jsnColaborador.length; i++) {
					strOptions += `<option value="${response.jsnColaborador[i].idcolaborador}">${response.jsnColaborador[i].nmcolaborador}</option>`;
				}

				$("#frmMultiploCadastroParticipacao #arrIdColaborador").html(strOptions);
				$("#frmMultiploCadastroParticipacao #arrIdColaborador").multipleSelect("refresh");
			},
			"json"
		);

		$("#WinMultiploCadastroParticipacao").data("kendoWindow").center().open();
		//---------------------------------------------------------------------------------//
	})
</script>

<form id="frmMultiploCadastroParticipacao">
	<div class="k-form">
		<table width=" 100%" border="0" cellspacing="2" cellpadding="0">
			<tr>
				<td class="k-required" style="width: 120px; text-align: right;">Treinamento:</td>
				<td>
					<input class="k-textbox k-input-disabled" readonly style="width: 60px;" id="idTreinamento"
						name="idTreinamento"
						value="<?php echo $objTbTreinamento->Get("idtreinamento") ?>" />

					<input class="k-textbox k-input-disabled" readonly style="width: 540px;" id="dsTitulo"
						name="dsTitulo"
						value="<?php echo $objTbTreinamento->Get("dstitulo") ?>" />

					<label for="dsTitulo" class="screenreader">Treinamento</label>
				</td>
			</tr>
		</table>

		<table width=" 100%" border="0" cellspacing="2" cellpadding="0">
			<tr>
				<td class="k-required" style="width: 120px; text-align: right;">Colaborador(es):</td>
				<td>
					<select style="width: 155px;" id="arrIdColaborador" name="arrIdColaborador">

					</select>
					<label for="arrIdColaborador" class="screenreader">Colaborador(es)</label>
				</td>
			</tr>
		</table>

		<div id="BarAcoes" style="text-align: right;height: 28px; position: relative"></div>
	</div>
</form>