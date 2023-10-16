document.addEventListener("DOMContentLoaded", function() {
    const titleInput = document.getElementById("title");
    const authorInput = document.getElementById("author");
    const addBookButton = document.getElementById("add-book");
    const bookList = document.getElementById("book-list");

    addBookButton.addEventListener("click", function() {
        const title = titleInput.value;
        const author = authorInput.value;

        if (title && author) {
            const li = document.createElement("li");
            li.innerHTML = `<span>${title} - ${author}</span> <button class="remove">Remover</button>`;
            bookList.appendChild(li);

            titleInput.value = "";
            authorInput.value = "";
        }
    });

    bookList.addEventListener("click", function(event) {
        if (event.target.classList.contains("remove")) {
            event.target.parentNode.remove();
        }
    });

    const searchTermInput = document.getElementById("search-term");
    const searchBooksButton = document.getElementById("search-books");

    searchBooksButton.addEventListener("click", function() {
        const searchTerm = searchTermInput.value;

        // Use a API do Google Books para buscar informações sobre livros
        fetch(`https://www.googleapis.com/books/v1/volumes?q=${searchTerm}`)
            .then(response => response.json())
            .then(data => {
                // Limpe a lista de resultados anteriores
                bookList.innerHTML = "";

                // Exiba os resultados da busca na página
                if (data.items) {
                    data.items.forEach(item => {
                        const title = item.volumeInfo.title;
                        const author = item.volumeInfo.authors ? item.volumeInfo.authors[0] : "Autor desconhecido";
                        const li = document.createElement("li");
                        li.innerHTML = `<span>${title} - ${author}</span> <button class="add">Adicionar</button>`;
                        bookList.appendChild(li);
                    });
                }
            });
    });

    bookList.addEventListener("click", function(event) {
        if (event.target.classList.contains("add")) {
            const bookInfo = event.target.parentElement.querySelector("span").textContent;
            const [title, author] = bookInfo.split(" - ");
            titleInput.value = title;
            authorInput.value = author;
        }
    });
});
