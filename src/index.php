<?php
@header("Content-Type: text/html; charset=ISO-8859-1", true);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <link href="img/icons/pg.favicon.png" rel="shortcut icon">

  <link href="css/pg.kendo.common.min.css" rel="stylesheet">
  <link href="css/pg.kendo.blueopal.min.css" rel="stylesheet">
  <link href="css/pg.kendo.blueopal.mobile.min.css" rel="stylesheet">
  <link href="css/pg.kendo.colors.min.css" rel="stylesheet">
  <link href="css/pg.icons.css" rel="stylesheet">
  <link href="css/pg.libFrontbox.css" rel="stylesheet">
  <link href="css/pg.multiple-select.css" rel="stylesheet">
  <link href="css/pg.loading.css" rel="stylesheet">
  <link href="css/kendo.global.min.css" rel="stylesheet">
  <link href="css/ckeditor.pontogov.css" rel="stylesheet">
  <link rel="stylesheet" href="js/prettyPhoto/css/prettyPhoto.css" type="text/css" media="screen" />
  <link href="js/rs-plugin/css/settings.css" rel="stylesheet">
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/redmond/jquery-ui.css">


  <script src="js/libJquery.js" charset="ISO-8859-1"></script>
  <script src="js/jszip.min.js" charset="ISO-8859-1"></script>
  <script src="js/kendo.all.min.js" charset="ISO-8859-1"></script>
  <script src="js/kendo.messages.pt-BR.min.js" charset="ISO-8859-1"></script>
  <script src="js/kendo.masked.date.picker.js" charset="ISO-8859-1"></script>
  <script src="js/kendo.culture.pt-BR.min.js" charset="ISO-8859-1"></script>
  <script src="js/pako_deflate.min.js" charset="ISO-8859-1"></script>
  <script src="js/libPgFilter.js" charset="ISO-8859-1"></script>

  <script src="js/fusion/fusioncharts.js"></script>
  <script src="js/fusion/themes/fusioncharts.theme.fint.js"></script>

  <script src="js/libUtils.js" charset="ISO-8859-1"></script>
  <script src="js/libFrontbox.js" charset="ISO-8859-1"></script>
  <script src="js/kendo.timezones.min.js" charset="ISO-8859-1"></script>
  <script src="js/ckeditor/ckeditor.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/multiple-select.js"></script>
  <script src="js/prettyPhoto/js/jquery.prettyPhoto.js" type="text/javascript"></script>
  <script src="js/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
  <script src="js/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
  <script src="js/mascara.js" type="text/javascript"></script>
  <script src="js/jquery.mask.js" charset="ISO-8859-1"></script>
</head>

<style>
  #app {
    height: 100vh;
    width: 100vw;
  }

  #splConsulta {
    height: 100vh;
  }

  #splConsulta #splHeader {
    background-color: #e0ecff !important;
    position: absolute;
  }

  #BarAcoes {
    position: absolute;
    width: 100%;
    bottom: 0px;
  }

  #splConsulta #splHeader .k-bg-blue.screen-filter-content {
    max-height: 58px;
    overflow: auto;
  }

  #splConsulta #splFooter {
    height: inherit;
  }

  #splConsulta #splFooter>div:nth-child(1) {
    height: inherit;
    overflow: hidden;
  }

  #splConsulta #splFooter>div:nth-child(1) .k-tabstrip-wrapper>div {
    height: inherit;
    overflow: hidden;
  }

  .k-tabstrip-wrapper {
    height: inherit;
  }

  .k-item.k-state-default {
    z-index: 0;
  }

  .k-form {
    height: 99%;
  }

  .k-form>form {
    height: 100%;
  }

  .k-form #splConsulta {
    height: inherit;
  }

  .k-form #splConsulta #splMiddle {
    overflow: hidden;
  }

  .k-header-column-menu.k-state-active {
    z-index: 0;
  }

  #splConsulta #splMiddle>div {
    height: 100% !important;
  }

  .k-splitter {
    border-width: 0px !important;
  }

  .k-i-hbar {
    margin-top: 2px !important;
    height: 2px !important;
  }

  .screenreader {
    position: absolute;
    left: -9999px;
  }

  .k-autocomplete,
  .k-colorpicker,
  .k-combobox,
  .k-datepicker,
  .k-datetimepicker,
  .k-dropdown,
  .k-dropdowntree,
  .k-listbox,
  .k-multiselect,
  .k-numerictextbox,
  .k-selectbox,
  .k-textbox,
  .k-timepicker {
    position: relative;
    display: inline-block;
    width: 12.4em;
    overflow: visible;
    /* border-width: 1px; */
    vertical-align: middle
  }
</style>

<body>
  <div id="app">
    <ul id="menu">
    </ul>
  </div>

  <div id="popNotificacao"></div>

  <script>
    kendo.culture("pt-BR");
    kendo.cultures["pt-BR"].numberFormat.currency.symbol = "R$";

    $(function () {
      $("#menu").kendoMenu({
        dataSource: [
          {
            text: "Treinamentos",
            attr: {
              "data-pagina": "ConsultaTreinamento",
              "data-url": "treinamento/ctrTreinamento.php?action=winConsulta"
            }
          },
          {
            text: "Colaboradores",
            attr: {
              "data-pagina": "ConsultaColaborador",
              "data-url": "colaborador/ctrColaborador.php?action=winConsulta"
            }
          },
        ],
        select: function (e) {
          const nmJanela = $(e.item).data("pagina");
          const dsUrl = $(e.item).data("url");

          OpenWindow(nmJanela, dsUrl, false);
        }
      })
    });

    function OpenWindow(nmJanela, dsUrl, blModal) {
      const containerId = `Win${nmJanela}`
      const filePath = `./controller/${dsUrl}`
      
      if ($(`#${containerId}`).length > 0) {
        $(`#${containerId}`).data("kendoWindow").close();
      }
      
      $("#app").append(`<div id="${containerId}"></div>`);

      $(`#${containerId}`).kendoWindow({
        modal: blModal,
        content: filePath,
        width: blModal ? "800px" : "99.8%",
        height: blModal ? "auto" : "90%",
        visible: !blModal,
        draggable: blModal,
        resizable: false,
        closable: blModal,
        close: function () {
          $(`#${containerId}`).remove();
        },
      });
    }
  </script>
</body>

</html>