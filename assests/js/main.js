

document.addEventListener('DOMContentLoaded', function () {
    fetchAndDisplayStudents();

    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function () {
        let searchTerm = this.value.trim().toLowerCase();
        filterStudents(searchTerm);
    });

    // Sorting functionality
    let sortOrder = 'asc'; 
    let sortBy = 'name'; 

    document.getElementById('sorting').addEventListener('click', function() {
        sortBy = 'name'; 
        sortOrder = sortOrder === 'asc' ? 'desc' : 'asc';
        fetchAndDisplayStudents(sortBy, sortOrder);
    });

    function fetchAndDisplayStudents(sortBy = 'id', sortOrder = 'asc') {
        fetch(`/controller/fetch_all_students.controller.php?sortBy=${sortBy}&sortOrder=${sortOrder}`)
        .then(response => response.json())
        .then(data => {
            renderStudents(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function filterStudents(searchTerm) {
        fetch(`/controller/fetch_all_students.controller.php?search=${searchTerm}`)
        .then(response => response.json())
        .then(data => {
            renderStudents(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function renderStudents(students) {
        let tableBody = document.querySelector('#studentTable tbody');
        tableBody.innerHTML = '';

        students.forEach(student => {
            let row = `
                <tr>
                    <td>${student.id}</td>
                    <td>${student.name}</td>
                    <td>${student.age}</td>
                    <td>${student.email}</td>
                    <td>
                        <button class="editBtn" data-id="${student.id}">Edit</button>
                        <button class="deleteBtn" data-id="${student.id}">Delete</button>
                    </td>
                </tr>
            `;
            tableBody.innerHTML += row;
        });
    }

    // Form submission handling
    document.getElementById('studentForm').addEventListener('submit', function (e) {
        e.preventDefault();

        let id = document.getElementById('id').value;
        let name = document.getElementById('name').value;
        let age = document.getElementById('age').value;
        let email = document.getElementById('email').value;
        let password = document.getElementById('password').value;
        let confirmPassword = document.getElementById('confirm_password').value;

        if (password !== confirmPassword) {
            alert('Passwords do not match!');
            return;
        }

        let data = {
            id: id,
            name: name,
            age: age,
            email: email,
            password: password
        };

        fetch('/controller/studentform.controller.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.message === "Student was created." || data.message === "Student was updated.") {
                document.getElementById('studentForm').reset();
                fetchAndDisplayStudents(sortBy, sortOrder);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    // Event action for edit and delete buttons
    document.querySelector('#studentTable').addEventListener('click', function(e) {
        if (e.target.classList.contains('editBtn')) {
            let id = e.target.getAttribute('data-id');
            fetch(`/controller/fetch_students.controller.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    alert(data.message);
                } else {
                    document.getElementById('id').value = data.id;
                    document.getElementById('name').value = data.name;
                    document.getElementById('age').value = data.age;
                    document.getElementById('email').value = data.email;
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        } else if (e.target.classList.contains('deleteBtn')) {
            let id = e.target.getAttribute('data-id');
            console.log('Deleting student with ID:', id);
            if (confirm('Are you sure you want to delete this student?')) {
                fetch('/controller/delete_student.controller.php', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: id })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    fetchAndDisplayStudents(sortBy, sortOrder);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        }
    });
});
