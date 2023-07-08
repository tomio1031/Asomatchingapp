document.getElementById('registrationForm').addEventListener('submit', function(event) {
    event.preventDefault();

    let student = {
        student_id: document.getElementById('student_id').value,
        name: document.getElementById('name').value,
        age: document.getElementById('age').value,
        gender: document.getElementById('gender').value,
        password: document.getElementById('password').value,
        hobby: document.getElementById('hobby').value,
    }

    fetch('http://localhost:8000', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(student),
    })
    .then(response => response.json())
    .then(data => console.log(data))
    .catch((error) => {
        console.error('Error:', error);
    });
});
