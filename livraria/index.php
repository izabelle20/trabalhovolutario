<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Livraria</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Livraria</h1>

    <div class="book-form">
        <h2>Adicionar Livro</h2>
        <input type="text" id="title" placeholder="Título do Livro">
        <input type="text" id="author" placeholder="Autor do Livro">
        <button id="add-book">Adicionar Livro</button>
    </div>

    <div class="book-list">
        <h2>Lista de Livros</h2>
        <ul id="book-list"></ul>
    </div>


    
    <div class="book-form">
        <h2>Buscar Livros</h2>
        <input type="text" id="search-term" placeholder="Título ou Autor do Livro">
        <button id="search-books">Buscar Livros</button>
    </div>

    <script src="script.js"></script>
</body>
</html>


