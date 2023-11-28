CREATE DATABASE quitanda;

USE quitanda;

-- -----------------------------------------------------
-- Table cliente
-- -----------------------------------------------------
CREATE TABLE cliente (
  codigo_cliente INT NOT NULL,
  nome_cliente VARCHAR(20) NOT NULL,
  endereco VARCHAR(30) NOT NULL,
  cidade VARCHAR(15) NOT NULL,
  CEP VARCHAR(8) NOT NULL,
  UF CHAR(2) NOT NULL,
  CPFCNPJ VARCHAR(20) NOT NULL,
  IE VARCHAR(20),
  tipo_cliente CHAR(1) NOT NULL COMMENT 'Tipo Cliente: F-Pessoa Fisica; J-Pessoa Juridica'
  );

-- -----------------------------------------------------
-- Table produto
-- -----------------------------------------------------
CREATE TABLE produto (
  codigo_produto INT NOT NULL,
  unidade CHAR(3) NOT NULL,
  descricao_produto VARCHAR(30) NOT NULL,
  valor_unitario DECIMAL(10,2) NOT NULL 
);

-- -----------------------------------------------------
-- Table vendedor
-- -----------------------------------------------------
CREATE TABLE vendedor (
  codigo_vendedor INT NOT NULL,
  nome_vendedor VARCHAR(20) NOT NULL,
  salario_fixo DECIMAL(10,2) NOT NULL,
  faixa_comissao CHAR(1) NOT NULL,
  sexo CHAR(1) NOT NULL 
);

-- -----------------------------------------------------
-- Table pedido
-- -----------------------------------------------------
CREATE TABLE pedido (
  num_pedido INT(11) NOT NULL,
  codigo_cliente INT(11) NOT NULL,
  codigo_vendedor INT(11) NOT NULL,
  data DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  prazo_entrega INT(11) NOT NULL,
  valor_total DECIMAL(10,2) NOT NULL DEFAULT '0.00',
  forma_pgto CHAR(3) NOT NULL,
  pago BIT NOT NULL DEFAULT b'0'
);

-- -----------------------------------------------------
-- Table item_do_pedido
-- -----------------------------------------------------
CREATE TABLE item_do_pedido (
  num_pedido INT NOT NULL,
  codigo_produto INT NOT NULL,
  quantidade INT NOT NULL,
  valor_item DECIMAL(10,2) NOT NULL DEFAULT '0.00'
);
