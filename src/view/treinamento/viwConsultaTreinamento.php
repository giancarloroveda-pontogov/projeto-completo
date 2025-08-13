<?php
@header("Content-Type: text/html; charset=ISO-8859-1", true);
?>

<script>
  	$(function () {

		//---------------------------------------------------------------------------------//
		// Definição do array data source
		//---------------------------------------------------------------------------------//
		var arrDataSource = [
			{
				name: "idtreinamento",
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
				label: "Título",
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
				name: "dsdescricao",
				type: "string",
				label: "Descrição",
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
				name: "dsareatecnica",
				type: "string",
				label: "Área Técnica",
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
				name: "nrcargahoraria",
				type: "integer",
				label: "Carga Horária",
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
			{
				name: "dstipo",
				type: "string",
				label: "Tipo",
				visibleFilter: 'true',
				orderFilter: '6',

				orderGrid: '6',
				widthGrid: '',
				hiddenGrid: 'false',
				headerAttributesGrid: 'font-weight: bold',
				attributesGrid: '',

				showPreview: 'true',
				indiceTabPreview: 'tabDadosGerais',
				widthPreview: '100',
				positionPreview: '6',
				togetherPreview: 'cdpagina'
			},
		];
		//---------------------------------------------------------------------------------//

		//---------------------------------------------------------------------------------//
		// Configurar a tela para usar splitter
		//---------------------------------------------------------------------------------//
		arrDataSource = LoadConfigurationQuery(arrDataSource, "ConsultaTreinamento")

		// Configuração manual do splitter
		$("#frmConsultaTreinamento #splConsulta").kendoSplitter({
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
		createPgFilter(arrDataSource, "ConsultaTreinamento")
		//---------------------------------------------------------------------------------//

		//---------------------------------------------------------------------------------//
		// Instanciando a barra de ações
		//---------------------------------------------------------------------------------//
		$("#frmConsultaTreinamento #BarAcoes").kendoToolBar({

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
								tabindex: "32"
							},
							click: function () {
								OpenWindow("CadastroTreinamento", "treinamento/ctrTreinamento.php?action=incluir", true);
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
								const grid = $("#frmConsultaTreinamento #GrdConsultaTreinamento").data("kendoGrid");
								const selectedRows = grid.select();
								const dataItem = grid.dataItem(selectedRows[0]);

								OpenWindow("CadastroTreinamento", `treinamento/ctrTreinamento.php?action=editar&idTreinamento=${dataItem.idtreinamento}`, true);
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
								$("#WinConsultaTreinamento").data("kendoWindow").close();
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
		$("#frmConsultaTreinamento #BtnPesquisar").kendoButton({
			click: function (e) {
				mountFilteredScreen('filterDefault', e, 'ConsultaTreinamento', arrDataSource, DtsConsultaTreinamento, getExtraFilter())
			}
		});
		//---------------------------------------------------------------------------------//

		//---------------------------------------------------------------------------------//
		// Filtro extra da consulta
		//---------------------------------------------------------------------------------//
		function getExtraFilter() {
			let arrFields = LoadFilterSplitter("ConsultaTreinamento", arrDataSource);

			return arrFields;
		}
		//---------------------------------------------------------------------------------//

		//---------------------------------------------------------------------------------//
		// Instanciando o dataSource da consulta
		//---------------------------------------------------------------------------------//
		var DtsConsultaTreinamento = new kendo.data.DataSource({
			pageSize: 100,
			serverPaging: true,
			serverFiltering: true,
			serverSorting: true,
			transport: {
				read: {
					url: "controller/treinamento/ctrTreinamento.php",
					type: "GET",
					dataType: "JSON",
					data: function() {
						return {
							action: "ListTreinamento"
						}
					}
				}
			},
			schema: {
				data: "jsnTreinamento",
				total: "jsnTotal",
				model: {
					fields: getModelDataSource(arrDataSource)
				},
				errors: "error"
			},
			error: function(e) {
				DlgError(e.errors);
			}
		});
		//---------------------------------------------------------------------------------//

		//---------------------------------------------------------------------------------//
		// Instanciando o Grid da consulta
		//---------------------------------------------------------------------------------//
		$("#frmConsultaTreinamento #GrdConsultaTreinamento").kendoGrid({
			dataSource: DtsConsultaTreinamento,
			height: getHeightGridQuery("ConsultaTreinamento"),
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
				SetAccess("T", "#frmConsultaTreinamento #BarAcoes", "#BtnEditar", true)
			},
			pageable: {
				pageSizes: [100, 200, 300, "all"],
				numeric: false,
				input: true,
			},
			columns: getColumnsQuery(arrDataSource),
			columnShow: function (e) { 
				setWidthOnShowColumnGrid(e, "ConsultaTreinamento");
			},
			columnHide: function (e) { 
				setWidthOnHideColumnGrid(e, "ConsultaTreinamento");
			},
			dataBound: function (e) { 
				LoadGridExportActions("frmConsultaTreinamento", "GrdConsultaTreinamento", <?= $frmResult === "" ?>)
			},
			filter: function (e) {
				mountFilteredScreen('filterColumn', e, 'ConsultaTreinamento', arrDataSource, DtsConsultaTreinamento, getExtraFilter())
			},
		});

		// Adicionando ação de duplo clique ao clicar no grid
		$("#frmConsultaTreinamento #GrdConsultaTreinamento").on("dblclick", "tbody > tr", function () {
			$("#frmConsultaTreinamento #BtnEditar").click();
		});
		//---------------------------------------------------------------------------------//

		//---------------------------------------------------------------------------------//
		// Definir preview do registro
		//---------------------------------------------------------------------------------//
		createScreenPreview(arrDataSource, "ConsultaTreinamento");
		//---------------------------------------------------------------------------------//

		$("#WinConsultaTreinamento").data("kendoWindow").center().open();
	});
</script>

<div id="frmConsultaTreinamento" class="k-form">
	<input type="hidden" name="idTreinamento" id="idTreinamento">
	<div id="splConsulta">
		<div id="splHeader">
			<div class="k-bg-blue screen-filter-content">
				<table>
					<tr>
						<td style="width: 120px;text-align: right;vertical-align: top;padding-top: 6px;">
							Filtro(s):
						</td>

						<td>
							<div id="fltConsultaTreinamento" style="width: auto;"></div>
						</td>

						<td style="vertical-align: bottom;padding-bottom: 5px;">
							<span id="BtnPesquisar" style="cursor: pointer;width: 100px;height: 24px;" title="Pesquisar"
								data-role="button" class="k-button k-button-icon" role="button" aria-disabled="false"
								tabindex="29">
								<span class="k-sprite k-pg-icon k-i-l1-c2"
									style="margin: 0 auto; text-align: center;"></span>
								<span style="margin: 0 auto; margin-right: 3px;">Pesquisar</span>
							</span>

							<span id="BtnAddFilter"
								style="cursor: pointer;width: 21px !important;height: 21px !important"
								title="Adicionar Filtro" data-role="button" class="k-button k-button-icon" role="button"
								aria-disabled="false" tabindex="">
								<span class="k-sprite k-pg-icon k-i-l1-c1"
									style="margin: 0 auto;margin-top: 1.4px;"></span>
							</span>
						</td>
					</tr>
				</table>

				<div id="BarAcoes" style="text-align: right;height: 28px;"></div>
			</div>
		</div>
		<div id="splMiddle">
			<div id="GrdConsultaTreinamento"></div>
		</div>
		<div id="splFooter">
			<div id="bottonConsultaTreinamento">
				<div id="tabStripConsultaTreinamento">
					<ul>
						<li id="tabDadosGerais" class="k-state-active"><label>Detalhes</label></li>
					</ul>
					<div id="tabDadosGeraisVisualizacaoConsultaTreinamento"></div>
				</div>
			</div>
		</div>
	</div>
</div>