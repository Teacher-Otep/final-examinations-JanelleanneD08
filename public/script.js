//function to show selected section
function showSection(sectionID){
    //initially, select all sections
    // use querySelectorAll for all sections with class content and homecontent
    const sections = document.querySelectorAll('.content');
    const homesection = document.querySelectorAll('.homecontent');

    //hide the resulting content sections using foreach
    sections.forEach(section => {
        section.style.display='none';
    });

    //also hide the home section
    homesection.forEach(section => {
        section.style.display='none';
    });

    //select the section that would
    //be displayed when clicked
    const activeSection = document.getElementById(sectionID);
    if(activeSection){
        activeSection.style.display='block';
    }
}

//function to hide all content sections when logo is clicked
function hideSections(){
    const sections = document.querySelectorAll('.content');
    sections.forEach(section => {
        section.style.display='none';
    });

    //show the home section
    const homesection = document.getElementById('home');
    if(homesection){
        homesection.style.display='block';
    }
}

//function to clear all text and number input fields (Clear Fields button)
function clearFields(){
    const inputs = document.querySelectorAll('#create input[type="text"], #create input[type="number"]');
    inputs.forEach(input => {
        input.value = '';
    });
}

//function to clear update form fields
function clearUpdateFields(){
    const inputs = document.querySelectorAll('#updateForm input[type="text"], #updateForm input[type="number"]');
    inputs.forEach(input => {
        input.value = '';
    });
}

//function to fetch student data by ID for updating
function fetchStudent(){
    const id = document.getElementById('select_id').value;
    if(!id){
        alert('Please enter a Student ID');
        return;
    }

    fetch('includes/fetch_student.php?id=' + id)
        .then(response => response.json())
        .then(data => {
            if(data.success){
                const student = data.student;
                document.getElementById('update_id').value = student.id;
                document.getElementById('update_name').value = student.name;
                document.getElementById('update_surname').value = student.surname;
                document.getElementById('update_middlename').value = student.middlename || '';
                document.getElementById('update_address').value = student.address || '';
                document.getElementById('update_contact').value = student.contact_number || '';
                document.getElementById('updateForm').style.display = 'block';
            } else {
                alert('Student not found. Please check the ID.');
                document.getElementById('updateForm').style.display = 'none';
            }
        })
        .catch(error => {
            alert('Error fetching student data.');
            console.error(error);
        });
}

//function to preview student before deletion
function previewDeleteStudent(){
    const id = document.getElementById('delete_id').value;
    if(!id){
        alert('Please enter a Student ID');
        return;
    }

    fetch('includes/fetch_student.php?id=' + id)
        .then(response => response.json())
        .then(data => {
            if(data.success){
                const student = data.student;
                document.getElementById('delete_student_name').textContent = 
                    student.surname + ', ' + student.name + ' ' + (student.middlename || '');
                document.getElementById('student-info-display').style.display = 'block';
            } else {
                alert('Student not found. Please check the ID.');
                document.getElementById('student-info-display').style.display = 'none';
            }
        })
        .catch(error => {
            alert('Error fetching student data.');
            console.error(error);
        });
}

//for the insertion/update/delete success toast messages
window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    if (status === 'success') {
        showToast('success-toast');
        showSection('create');
    } else if (status === 'updated') {
        showToast('update-toast');
        showSection('read');
    } else if (status === 'deleted') {
        showToast('delete-toast');
        showSection('read');
    }

    // Clean the URL
    if(status){
        window.history.replaceState({}, document.title, window.location.pathname);
    }
}

//helper function to show toast notifications
function showToast(toastId){
    const toast = document.getElementById(toastId);
    toast.classList.remove('toast-hidden');
    
    // Hide it automatically after 3 seconds
    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => {
            toast.classList.add('toast-hidden');
            toast.style.opacity = '1';
        }, 500);
    }, 3000);
}
