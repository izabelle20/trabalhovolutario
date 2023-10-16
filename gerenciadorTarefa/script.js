const generateButton = document.getElementById('generate-btn');
const taskElement = document.getElementById('task');

generateButton.addEventListener('click', () => {
    fetch('task_generator.php')
        .then(response => response.text())
        .then(data => {
            taskElement.textContent = data;
        })
        .catch(error => {
            console.error('Houve um erro ao obter a tarefa:', error);
        });
});
