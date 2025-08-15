<?php
@header("Content-Type: text/html; charset=ISO-8859-1", true);
?>

<script>
	$(function () {
		function getSelectedTbColaborador() {
			const grid = $("#frmConsultaColaborador #GrdConsultaColaborador").data("kendoGrid");
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
				name: "idcolaborador",
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
				name: "nmcolaborador",
				type: "string",
				label: "Nome",
				visibleFilter: 'true',
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
				name: "dsemail",
				type: "string",
				label: "E-mail",
				visibleFilter: 'true',
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
			{
				name: "dssetor",
				type: "string",
				label: "Setor",
				visibleFilter: 'true',
				orderFilter: '4',

				orderGrid: '4',
				widthGrid: '',
				hiddenGrid: 'false',
				headerAttributesGrid: 'font-weight: bold',
				attributesGrid: '',

				showPreview: 'true',
				indiceTabPreview: 'tabDadosGerais',
				widthPreview: '600',
				positionPreview: '4'
			},
			{
				name: "dtcontratacao",
				type: "date",
				label: "Data de Contratação",
				visibleFilter: 'true',
				orderFilter: '5',

				orderGrid: '5',
				widthGrid: '',
				hiddenGrid: 'false',
				headerAttributesGrid: 'font-weight: bold',
				attributesGrid: '',

				showPreview: 'true',
				indiceTabPreview: 'tabDadosGerais',
				widthPreview: '80',
				positionPreview: '5'
			},
		];
		//---------------------------------------------------------------------------------//

		//---------------------------------------------------------------------------------//
		// Configurar a tela para usar splitter
		//---------------------------------------------------------------------------------//
		arrDataSource = LoadConfigurationQuery(arrDataSource, "ConsultaColaborador")

		// Configuração manual do splitter
		$("#frmConsultaColaborador #splConsulta").kendoSplitter({
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
		createPgFilter(arrDataSource, "ConsultaColaborador")
		//---------------------------------------------------------------------------------//

		//---------------------------------------------------------------------------------//
		// Instanciando a barra de ações
		//---------------------------------------------------------------------------------//
		$("#frmConsultaColaborador #BarAcoes").kendoToolBar({

			items: [
				{
					type: "spacer"
				},
				{
					type: "button",
					id: "BtnAcessoRapido",
					hidden: false,
					spriteCssClass: "k-pg-icon k-i-l2-c10",
					text: "Acesso Rápido <span class='k-icon k-i-arrow-s' style='width: 12px;'></span>",
					enable: false,
					group: "actions",
					attributes: {
						tabindex: "31"
					},
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
								tabindex: "32"
							},
							click: function () {
								OpenWindow("CadastroColaborador", "colaborador/ctrColaborador.php?action=incluir", true);
							}
						},
						{
							id: "BtnEditar",
							spriteCssClass: "k-pg-icon k-i-l1-c3",
							text: "Editar",
							group: "actions",
							enable: false,
							attributes: {
								tabindex: "33"
							},
							click: function () {
								const grid = $("#frmConsultaColaborador #GrdConsultaColaborador").data("kendoGrid");
								const selectedRows = grid.select();
								const dataItem = grid.dataItem(selectedRows[0]);

								OpenWindow("CadastroColaborador", `colaborador/ctrColaborador.php?action=editar&idColaborador=${dataItem.idcolaborador}`, true);
							}
						},
						{
							id: "BtnFechar",
							spriteCssClass: "k-pg-icon k-i-l1-c4",
							text: "Fechar",
							group: "actions",
							attributes: {
								tabindex: "34"
							},
							click: function () {
								$("#WinConsultaColaborador").data("kendoWindow").close();
							}
						},
					]
				}
			],
		})

		if ($("#menuAcessoRapidoColaborador").data("kenodContextMenu")) {
			$("#menuAcessoRapidoColaborador").data("kenodContextMenu").destroy();
		}

		$("#frmConsultaColaborador #menuAcessoRapidoColaborador").kendoContextMenu({
			target: "#frmConsultaColaborador #BtnAcessoRapido",
			alignToAnchor: true,
			showOn: "click",
			select: function (e) {
				const actions = {
					"BtnParticipacao": () => {
						const dataItem = getSelectedTbColaborador();

						OpenWindow("ConsultaParticipacao", `participacao/ctrParticipacao.php?action=winConsulta&idColaborador=${dataItem.idcolaborador}`, false);
					}
				};

				const action = actions[e.item.id];
				if (action) action();
			}
		});
		//---------------------------------------------------------------------------------//

		//---------------------------------------------------------------------------------//
		// Instanciando o botão de consulta
		//---------------------------------------------------------------------------------//
		$("#frmConsultaColaborador #BtnPesquisar").kendoButton({
			click: function (e) {
				mountFilteredScreen('filterDefault', e, 'ConsultaColaborador', arrDataSource, DtsConsultaColaborador, getExtraFilter())
			}
		});
		//---------------------------------------------------------------------------------//

		//---------------------------------------------------------------------------------//
		// Filtro extra da consulta
		//---------------------------------------------------------------------------------//
		function getExtraFilter() {
			let arrFields = LoadFilterSplitter("ConsultaColaborador", arrDataSource);

			return arrFields;
		}
		//---------------------------------------------------------------------------------//

		//---------------------------------------------------------------------------------//
		// Instanciando o dataSource da consulta
		//---------------------------------------------------------------------------------//
		var DtsConsultaColaborador = new kendo.data.DataSource({
			pageSize: 100,
			serverPaging: true,
			serverFiltering: true,
			serverSorting: true,
			transport: {
				read: {
					url: "controller/colaborador/ctrColaborador.php",
					type: "GET",
					dataType: "JSON",
					data: function () {
						return {
							action: "ListColaborador",
							filters: getExtraFilter()
						}
					}
				}
			},
			schema: {
				data: "jsnColaborador",
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
		$("#frmConsultaColaborador #GrdConsultaColaborador").kendoGrid({
			dataSource: DtsConsultaColaborador,
			height: getHeightGridQuery("ConsultaColaborador"),
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
				SetAccess("T", "#frmConsultaColaborador #BarAcoes", "#BtnEditar", true);
				SetAccess("T", "#frmConsultaColaborador #BarAcoes", "#BtnAcessoRapido", true);
			},
			pageable: {
				pageSizes: [100, 200, 300, "all"],
				numeric: false,
				input: true,
			},
			columns: getColumnsQuery(arrDataSource),
			columnShow: function (e) {
				setWidthOnShowColumnGrid(e, "ConsultaColaborador");
			},
			columnHide: function (e) {
				setWidthOnHideColumnGrid(e, "ConsultaColaborador");
			},
			dataBound: function (e) {
				LoadGridExportActions("frmConsultaColaborador", "GrdConsultaColaborador", <?= $frmResult === "" ?>)
			},
			filter: function (e) {
				mountFilteredScreen('filterColumn', e, 'ConsultaColaborador', arrDataSource, DtsConsultaColaborador, getExtraFilter())
			},
		});

		// Adicionando ação de duplo clique ao clicar no grid
		$("#frmConsultaColaborador #GrdConsultaColaborador").on("dblclick", "tbody > tr", function () {
			$("#frmConsultaColaborador #BtnEditar").click();
		});
		//---------------------------------------------------------------------------------//

		//---------------------------------------------------------------------------------//
		// Definir preview do registro
		//---------------------------------------------------------------------------------//
		createScreenPreview(arrDataSource, "ConsultaColaborador");
		//---------------------------------------------------------------------------------//

		$("#WinConsultaColaborador").data("kendoWindow").center().open();
	});
</script>

<style>
	#menuAcessoRapidoTreinamento {
		border: 0.5px solid #5a8cd7 !important;
	}
</style>

<div id="frmConsultaColaborador" class="k-form">
	<input type="hidden" name="idColaborador" id="idColaborador">
	<div id="splConsulta">
		<div id="splHeader">
			<div class="k-bg-blue screen-filter-content">
				<table>
					<tr>
						<td style="width: 120px;text-align: right;vertical-align: top;padding-top: 6px;">
							Filtro(s):
						</td>

						<td>
							<div id="fltConsultaColaborador" style="width: auto;"></div>
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
			<div id="GrdConsultaColaborador"></div>

			<ul id="menuAcessoRapidoColaborador" style="display: none; width: 100px;">
				<li id="BtnParticipacao"><span class="k-pg-icon k-i-l1-c1"></span> Participações</li>
			</ul>
		</div>
		<div id="splFooter">
			<div id="bottonConsultaColaborador">
				<div id="tabStripConsultaColaborador">
					<ul>
						<li id="tabDadosGerais" class="k-state-active"><label>Detalhes</label></li>
					</ul>
					<div id="tabDadosGeraisVisualizacaoConsultaColaborador"></div>
				</div>
			</div>
		</div>
	</div>
</div>