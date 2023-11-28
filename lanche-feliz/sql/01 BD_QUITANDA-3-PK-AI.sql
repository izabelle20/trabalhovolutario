-- setar o database
USE quitanda;

-- alterando propriedade AI para PK cliente
ALTER TABLE CLIENTE
	MODIFY CODIGO_CLIENTE INT NOT NULL AUTO_INCREMENT;
    
-- alterando propriedade AI para PK produto
ALTER TABLE PRODUTO
	MODIFY CODIGO_PRODUTO INT NOT NULL AUTO_INCREMENT;
    
-- alterando propriedade AI para PK vendedor
ALTER TABLE VENDEDOR
	MODIFY CODIGO_VENDEDOR INT NOT NULL AUTO_INCREMENT;
    
-- alterando propriedade AI para PK pedido
ALTER TABLE PEDIDO
	MODIFY NUM_PEDIDO INT NOT NULL AUTO_INCREMENT;