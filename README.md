# Treinamento PontoGOV Sistemas - Projeto Pr�tico V

## **Enunciado**

A proposta deste projeto � a cria��o de um pequeno sistema interno para **gerenciar treinamentos t�cnicos e comportamentais oferecidos aos colaboradores**. A aplica��o dever� ser constru�da com **PHP, PostgreSQL, jQuery e Kendo UI**, sem o uso de bibliotecas internas da empresa (por enquanto).

Este projeto tem o objetivo de consolidar o dom�nio da stack b�sica com foco em:

- Cria��o de telas com componentes interativos (grids, inputs, selects etc.) usando Kendo UI e jQuery;
- Comunica��o ass�ncrona com PHP atrav�s de chamadas AJAX;
- Manipula��o de dados no banco PostgreSQL com SQL puro;
- Separa��o clara entre front e back (mesmo que em PHP).

---

### **CRUDs a serem desenvolvidos**

#### 1. **Treinamentos**

- Cadastro de treinamentos (t�tulo, descri��o, �rea t�cnica, carga hor�ria, tipo: t�cnico ou comportamental).
- Listagem com grid interativa (Kendo UI) e filtros por tipo.
- Edi��o e exclus�o.

#### 2. **Colaboradores**

- Cadastro com nome, e-mail, setor e data de contrata��o.
- Edi��o, busca por nome e exclus�o.
- Relacionamento posterior com treinamentos.

#### 3. **Participa��es**

- Registro da participa��o de colaboradores em treinamentos.
- Deve associar um colaborador a um treinamento espec�fico (relacional).
- Permitir visualizar todos os colaboradores de um treinamento (e vice-versa).
- CRUD completo de participa��es (adicionar, editar presen�a/situa��o, excluir).

---

### **Requisitos Funcionais Adicionais**

- Todas as a��es devem ser feitas via AJAX (sem reload da p�gina).
- O front deve ser montado em HTML/PHP com uso de Kendo UI para os componentes de UI.
- O backend deve estar preparado para receber, processar e responder requisi��es ass�ncronas de forma estruturada (JSON de entrada e sa�da).
- Deve haver tratamento de erros b�sicos tanto no front quanto no back.

---

### **Desafios Extras (opcionais)**

- Adicionar campo de observa��es na participa��o do colaborador.
- Implementar filtro por setor na visualiza��o de treinamentos por colaborador.
- Gerar relat�rio simples em tela mostrando os treinamentos mais populares (por n�mero de participa��es).
- Adicionar valida��es no front e no back (ex: e-mail v�lido, campos obrigat�rios).
- Mantenha as boas pr�ticas e padr�es de c�digo adotados pela empresa.
- Use mensagens de commit claras e sem�nticas.