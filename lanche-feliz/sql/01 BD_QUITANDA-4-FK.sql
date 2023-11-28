-- setar o database
USE quitanda;

--  adicionando constraint FK na tabela pedido para table vendedor
ALTER TABLE pedido
	ADD CONSTRAINT fk_pedido_vendedor
	FOREIGN KEY (codigo_vendedor)
	REFERENCES vendedor(codigo_vendedor);

-- adicionando constraint FK na tabela pedido para table cliente
ALTER TABLE pedido
	ADD CONSTRAINT fk_pedido_cliente 
	FOREIGN KEY(codigo_cliente) 
	REFERENCES cliente(codigo_cliente);

-- adicionando constraint FK na tabela item_do_pedido para table pedido
ALTER TABLE item_do_pedido
	ADD CONSTRAINT fk_ip_pedido
	FOREIGN KEY (num_pedido)
	REFERENCES pedido(num_pedido);
	
-- adicionando constraint FK na tabela item_do_pedido para table produto
ALTER TABLE item_do_pedido
	ADD CONSTRAINT fk_ip_produto
	FOREIGN KEY (codigo_produto)
	REFERENCES produto(codigo_produto);