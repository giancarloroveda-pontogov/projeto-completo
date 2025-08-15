<?php
@header("Content-Type: text/html; charset=ISO-8859-1", true);
?>

<script>
	$(function () {
		function getSelectedTbParticipacao() {
			const grid = $("#frmConsultaParticipacao #GrdConsultaParticipacao").data("kendoGrid");
			const selectedRows = grid.select();

			if (selectedRows.length === 0) {
				return null;
			}

			return grid.dataItem(selectedRows[0]);
		}

		//---------------------------------------------------------------------------------//
		// Definição do array data source
		//---------------------------------------------------------------------------------//
		var arrDataSource = [
			{
				name: "idparticipacao",
				type: "integer",
				label: "Id",
				visibleFilter: 'true',
				orderFilter: '2',

				orderGrid: '1',
				widthGrid: '70',
				hiddenGrid: 'false',
				headerAttributesGrid: 'font-weight: bold',
				attributesGrid: '',

				showPreview: 'true',
				indiceTabPreview: 'tabDadosGerais',
				widthPreview: '80',
				positionPreview: '1'
			},
			{
				name: "dstitulo",
				type: "string",
				label: "Treinamento",
				visibleFilter: 'false',
				orderFilter: '1',

				orderGrid: '2',
				widthGrid: '',
				hiddenGrid: 'false',
				headerAttributesGrid: 'font-weight: bold',
				attributesGrid: '',

				showPreview: 'true',
				indiceTabPreview: 'tabDadosGerais',
				widthPreview: '600',
				positionPreview: '2'
			},
			{
				name: "nmcolaborador",
				type: "string",
				label: "Colaborador",
				visibleFilter: 'false',
				orderFilter: '3',

				orderGrid: '3',
				widthGrid: '',
				hiddenGrid: 'false',
				headerAttributesGrid: 'font-weight: bold',
				attributesGrid: '',

				showPreview: 'true',
				indiceTabPreview: 'tabDadosGerais',
				widthPreview: '600',
				positionPreview: '3'
			},
		];
		//---------------------------------------------------------------------------------//

		//---------------------------------------------------------------------------------//
		// Configurar a tela para usar splitter
		//---------------------------------------------------------------------------------//
		arrDataSource = LoadConfigurationQuery(arrDataSource, "ConsultaParticipacao")

		// Configuração manual do splitter
		$("#frmConsultaParticipacao #splConsulta").kendoSplitter({
			orientation: 'vertical',
			panes: [
				{ size: "15%" },
				{ size: "55%" },
				{ size: "30%" },
			]
		});
		//---------------------------------------------------------------------------------//

		//---------------------------------------------------------------------------------//
		// Instanciando os campos combo da consulta
		//---------------------------------------------------------------------------------//
		createPgFilter(arrDataSource, "ConsultaParticipacao")

		$("#frmConsultaParticipacao #idTreinamento").multipleSelect({
			placeholder: "Selecione uma opção",
			selectAllText: "Selecionar todos",
			allSelected: "Todos selecionados",
			filter: true,
		});

		$("#frmConsultaParticipacao #idColaborador").multipleSelect({
			placeholder: "Selecione uma opção",
			selectAllText: "Selecionar todos",
			allSelected: "Todos selecionados",
			filter: true,
		});

		const pmsColaborador = $.post(
			"controller/colaborador/ctrColaborador.php?action=ListColaborador",
			function (response) {
				let strOptions = "";
				for (let i = 0; i < response.jsnColaborador.length; i++) {
					strOptions += `<option ${response.jsnColaborador[i].idcolaborador == "<?php echo $idColaborador ?>" ? "selected" : ""} value="${response.jsnColaborador[i].idcolaborador}">${response.jsnColaborador[i].nmcolaborador}</option>`;
				}

				$("#frmConsultaParticipacao #idColaborador").html(strOptions);
				$("#frmConsultaParticipacao #idColaborador").multipleSelect("refresh");

				let n = 0;
			},
			"json"
		);

		const pmsTreinamento = $.post(
			"controller/treinamento/ctrTreinamento.php?action=ListTreinamento",
			function (response) {
				let strOptions = "";
				for (i = 0; i < response.jsnTreinamento.length; i++) {
					strOptions += `<option ${response.jsnTreinamento[i].idtreinamento == "<?php echo $idTreinamento ?>" ? "selected" : ""} value="${response.jsnTreinamento[i].idtreinamento}">${response.jsnTreinamento[i].dstitulo}</option>`;
				}

				$("#frmConsultaParticipacao #idTreinamento").html(strOptions);
				$("#frmConsultaParticipacao #idTreinamento").multipleSelect("refresh");
			},
			"json"
		);

		Promise.all([pmsTreinamento, pmsColaborador])
			.then(() => {
				$("#frmConsultaParticipacao #BtnPesquisar").click();
			})

		//---------------------------------------------------------------------------------//

		//---------------------------------------------------------------------------------//
		// Instanciando a barra de ações
		//---------------------------------------------------------------------------------//
		$("#frmConsultaParticipacao #BarAcoes").kendoToolBar({
			items: [
				{
					type: "spacer"
				},
				{
					type: "buttonGroup",
					buttons: [
						{
							id: "BtnIncluir",
							spriteCssClass: "k-pg-icon k-i-l1-c1",
							text: "Incluir",
							group: "actions",
							attributes: {
								tabindex: "33"
							},
							click: function () {
								OpenWindow("CadastroParticipacao", "participacao/ctrParticipacao.php?action=incluir", true);
							}
						},
						{
							id: "BtnEditar",
							spriteCssClass: "k-pg-icon k-i-l1-c3",
							text: "Editar",
							group: "actions",
							enable: false,
							attributes: {
								tabindex: "34"
							},
							click: function () {
								const dataItem = getSelectedTbParticipacao();

								OpenWindow("CadastroParticipacao", `participacao/ctrParticipacao.php?action=editar&idParticipacao=${dataItem.idparticipacao}`, true);
							}
						},
						{
							id: "BtnFechar",
							spriteCssClass: "k-pg-icon k-i-l1-c4",
							text: "Fechar",
							group: "actions",
							attributes: {
								tabindex: "35"
							},
							click: function () {
								$("#WinConsultaParticipacao").data("kendoWindow").close();
							}
						},
					]
				}
			],
		})
		//---------------------------------------------------------------------------------//

		//---------------------------------------------------------------------------------//
		// Instanciando o botão de consulta
		//---------------------------------------------------------------------------------//
		$("#frmConsultaParticipacao #BtnPesquisar").kendoButton({
			click: function (e) {
				mountFilteredScreen('filterDefault', e, 'ConsultaParticipacao', arrDataSource, DtsConsultaParticipacao, getExtraFilter())
			}
		});
		//---------------------------------------------------------------------------------//

		//---------------------------------------------------------------------------------//
		// Filtro extra da consulta
		//---------------------------------------------------------------------------------//
		function getExtraFilter() {
			let arrFields = LoadFilterSplitter("ConsultaParticipacao", arrDataSource);

			return arrFields;
		}
		//---------------------------------------------------------------------------------//

		//---------------------------------------------------------------------------------//
		// Instanciando o dataSource da consulta
		//---------------------------------------------------------------------------------//
		var DtsConsultaParticipacao = new kendo.data.DataSource({
			pageSize: 100,
			serverPaging: true,
			serverFiltering: true,
			serverSorting: true,
			transport: {
				read: {
					url: "controller/participacao/ctrParticipacao.php",
					type: "GET",
					dataType: "JSON",
					data: function () {
						return {
							action: "ListParticipacao",
							filters: getExtraFilter(),
							arrIdColaborador: $("#frmConsultaParticipacao #idColaborador").multipleSelect("getSelects"),
							arrIdTreinamento: $("#frmConsultaParticipacao #idTreinamento").multipleSelect("getSelects"),
						}
					}
				}
			},
			schema: {
				data: "jsnParticipacao",
				total: "jsnTotal",
				model: {
					fields: getModelDataSource(arrDataSource)
				},
				errors: "error"
			},
			error: function (e) {
				DlgError(e.errors);
			}
		});
		//---------------------------------------------------------------------------------//

		//---------------------------------------------------------------------------------//
		// Instanciando o Grid da consulta
		//---------------------------------------------------------------------------------//
		$("#frmConsultaParticipacao #GrdConsultaParticipacao").kendoGrid({
			dataSource: DtsConsultaParticipacao,
			autoBind: false,
			height: getHeightGridQuery("ConsultaParticipacao"),
			selectable: true,
			resizable: true,
			reorderable: true,
			navigatable: true,
			columnMenu: true,
			filterable: true,
			sortable: {
				mode: "multiple",
				allowUnsort: true,
			},
			sort: function () { },
			change: function () {
				SetAccess("T", "#frmConsultaParticipacao #BarAcoes", "#BtnEditar", true)
			},
			pageable: {
				pageSizes: [100, 200, 300, "all"],
				numeric: false,
				input: true,
			},
			columns: getColumnsQuery(arrDataSource),
			columnShow: function (e) {
				setWidthOnShowColumnGrid(e, "ConsultaParticipacao");
			},
			columnHide: function (e) {
				setWidthOnHideColumnGrid(e, "ConsultaParticipacao");
			},
			dataBound: function (e) {
				LoadGridExportActions("frmConsultaParticipacao", "GrdConsultaParticipacao", <?= $frmResult === "" ?>)
			},
			filter: function (e) {
				mountFilteredScreen('filterColumn', e, 'ConsultaParticipacao', arrDataSource, DtsConsultaParticipacao, getExtraFilter())
			},
		});

		// Adicionando ação de duplo clique ao clicar no grid
		$("#frmConsultaParticipacao #GrdConsultaParticipacao").on("dblclick", "tbody > tr", function () {
			$("#frmConsultaParticipacao #BtnEditar").click();
		});
		//---------------------------------------------------------------------------------//

		//---------------------------------------------------------------------------------//
		// Definir preview do registro
		//---------------------------------------------------------------------------------//
		createScreenPreview(arrDataSource, "ConsultaParticipacao");
		//---------------------------------------------------------------------------------//

		$("#WinConsultaParticipacao").data("kendoWindow").center().open();
	});
</script>

<div id="frmConsultaParticipacao" class="k-form">
	<input type="hidden" name="idParticipacao" id="idParticipacao">
	<div id="splConsulta">
		<div id="splHeader">
			<div class="k-bg-blue screen-filter-content">
				<table width="100%" border="0" cellspacing="2" cellpadding="0">
					<tr>
						<td class="" style="width: 120px; text-align: right;">Treinamento:</td>
						<td style="width: 270px;">
							<select name="idTreinamento[]" multiple="multiple" id="idTreinamento" style="width: 150px">
							</select>
							<label for="idTreinamento" class="screenreader">Título</label>
						</td>

						<td class="" style="width: 120px; text-align: right;">Colaborador:</td>
						<td>
							<select name="idColaborador[]" multiple="multiple" id="idColaborador" style="width: 150px"></select>
							<label for="idColaborador" class="screenreader">Título</label>
						</td>
					</tr>
				</table>

				<table>
					<tr>
						<td style="width: 120px;text-align: right;vertical-align: top;padding-top: 6px;">
							Filtro(s):
						</td>

						<td>
							<div id="fltConsultaParticipacao" style="width: auto;"></div>
						</td>

						<td style="vertical-align: bottom;padding-bottom: 5px;">
							<span id="BtnPesquisar" style="cursor: pointer;width: 100px;height: 24px;" title="Pesquisar"
								data-role="button" class="k-button k-button-icon" role="button" aria-disabled="false" tabindex="29">
								<span class="k-sprite k-pg-icon k-i-l1-c2" style="margin: 0 auto; text-align: center;"></span>
								<span style="margin: 0 auto; margin-right: 3px;">Pesquisar</span>
							</span>

							<span id="BtnAddFilter" style="cursor: pointer;width: 21px !important;height: 21px !important"
								title="Adicionar Filtro" data-role="button" class="k-button k-button-icon" role="button"
								aria-disabled="false" tabindex="">
								<span class="k-sprite k-pg-icon k-i-l1-c1" style="margin: 0 auto;margin-top: 1.4px;"></span>
							</span>
						</td>
					</tr>
				</table>

				<div id="BarAcoes" style="text-align: right;height: 28px;"></div>
			</div>
		</div>
		<div id="splMiddle">
			<div id="GrdConsultaParticipacao"></div>
		</div>
		<div id="splFooter">
			<div id="bottonConsultaParticipacao">
				<div id="tabStripConsultaParticipacao">
					<ul>
						<li id="tabDadosGerais" class="k-state-active"><label>Detalhes</label></li>
					</ul>
					<div id="tabDadosGeraisVisualizacaoConsultaParticipacao"></div>
				</div>
			</div>
		</div>
	</div>
</div>