# Treinamento PontoGOV Sistemas - Projeto Prático V

## **Enunciado**

A proposta deste projeto é a criação de um pequeno sistema interno para **gerenciar treinamentos técnicos e comportamentais oferecidos aos colaboradores**. A aplicação deverá ser construída com **PHP, PostgreSQL, jQuery e Kendo UI**, sem o uso de bibliotecas internas da empresa (por enquanto).

Este projeto tem o objetivo de consolidar o domínio da stack básica com foco em:

- Criação de telas com componentes interativos (grids, inputs, selects etc.) usando Kendo UI e jQuery;
- Comunicação assíncrona com PHP através de chamadas AJAX;
- Manipulação de dados no banco PostgreSQL com SQL puro;
- Separação clara entre front e back (mesmo que em PHP).

---

### **CRUDs a serem desenvolvidos**

#### 1. **Treinamentos**

- Cadastro de treinamentos (título, descrição, área técnica, carga horária, tipo: técnico ou comportamental).
- Listagem com grid interativa (Kendo UI) e filtros por tipo.
- Edição e exclusão.

#### 2. **Colaboradores**

- Cadastro com nome, e-mail, setor e data de contratação.
- Edição, busca por nome e exclusão.
- Relacionamento posterior com treinamentos.

#### 3. **Participações**

- Registro da participação de colaboradores em treinamentos.
- Deve associar um colaborador a um treinamento específico (relacional).
- Permitir visualizar todos os colaboradores de um treinamento (e vice-versa).
- CRUD completo de participações (adicionar, editar presença/situação, excluir).

---

### **Requisitos Funcionais Adicionais**

- Todas as ações devem ser feitas via AJAX (sem reload da página).
- O front deve ser montado em HTML/PHP com uso de Kendo UI para os componentes de UI.
- O backend deve estar preparado para receber, processar e responder requisições assíncronas de forma estruturada (JSON de entrada e saída).
- Deve haver tratamento de erros básicos tanto no front quanto no back.

---

### **Desafios Extras (opcionais)**

- Adicionar campo de observações na participação do colaborador.
- Implementar filtro por setor na visualização de treinamentos por colaborador.
- Gerar relatório simples em tela mostrando os treinamentos mais populares (por número de participações).
- Adicionar validações no front e no back (ex: e-mail válido, campos obrigatórios).
- Mantenha as boas práticas e padrões de código adotados pela empresa.
- Use mensagens de commit claras e semânticas.