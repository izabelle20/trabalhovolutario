-- setar o database
USE quitanda;

-- adicionando constraint pk para table cliente
ALTER TABLE	cliente
	ADD CONSTRAINT pk_cliente
	PRIMARY KEY (codigo_cliente);

-- adicionando constraint pk para table vendedor
ALTER TABLE	vendedor
	ADD CONSTRAINT pk_vendedor
	PRIMARY KEY (codigo_vendedor);

-- adicionando constraint pk para table pedido
ALTER TABLE	pedido
	ADD CONSTRAINT pk_pedido
	PRIMARY KEY(num_pedido);

-- adicionando constraint pk para table produto
ALTER TABLE	produto
	ADD CONSTRAINT pk_produto
	PRIMARY KEY(codigo_produto);
	
-- adicionando constraint pk para table item_do_pedido
ALTER TABLE item_do_pedido
	ADD CONSTRAINT pk_item_do_pedido
	PRIMARY KEY (num_pedido, codigo_produto); -- PK Composta