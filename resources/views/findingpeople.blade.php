<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toggle Between Find Employee and Find Employer</title>
</head>
<style>
        /* General Styles */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: flex-start; /* Align at the top */
        height: 100vh;
        background-color: #f4f4f4;
    }

    .container {
        width: 90%; /* Set the width to 90% of the screen */
        max-width: 1000px; /* Maximum width of 1000px */
        margin: 20px auto; /* Equal margin on the left and right to center it */
    }

    .tabs {
        display: flex;
        justify-content: center; /* Center the images and text horizontally */
        gap: 300px; /* Space between images */
        margin-bottom: 10px; /* Space between the images and the content */
    }

    .tab {
        text-align: center; /* Center the text under the images */
        cursor: pointer; /* Pointer cursor to indicate it's clickable */
        transition: transform 0.3s, box-shadow 0.3s;
        border-radius: 5px;
        border:1px solid black;
        padding:5px;
    }

    .tab-image {
        width: 25%; /* Reduced image width to 25% of the container */
        border-radius: 5px;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .tab:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .tab-text {
        margin-top: 10px; /* Space between image and text */
        font-size: 18px;
        color: #333;
    }

    .separator {
        border: none;
        border-top: 2px solid #ddd;
        margin: 20px 0; /* Space above and below the line */
    }

    .content {
        border: 1px solid #ddd;
        padding: 20px;
        background-color: white;
        border-radius: 5px;
    }

    .content-tab {
        display: none;
    }

    h2 {
        font-size: 24px;
        margin-bottom: 10px;
    }

    p {
        font-size: 18px;
    }

    /* Show the selected content */
    .show {
        display: block;
    }

</style>
<body>

<div class="container">
    <!-- Top Section: Find Employee and Find Employer tabs with images -->
    <div class="tabs">
        <div class="tab" onclick="toggleTab('employee')">
            <img src="https://cdn-icons-png.flaticon.com/128/6462/6462992.png" alt="Find Employee" class="tab-image">
            <p class="tab-text">Finding Employee</p>
        </div>
        <div class="tab" onclick="toggleTab('employer')">
            <img src="https://cdn-icons-png.flaticon.com/128/5545/5545080.png" alt="Find Employer" class="tab-image">
            <p class="tab-text">Finding Employer</p>
        </div>
    </div>
    
    <!-- Horizontal line separator -->
    <hr class="separator">
    <input type="text" name="search" id="search" placeholder="search" style="font-size:30px; border-radius:5px; margin-bottom:5px;">
    <!-- Content Section -->
    <div class="content">
    
        <div id="employee" class="content-tab">
        @foreach($employees as $employee)
            <div class="contact" style="display: flex; justify-content: space-between; align-items: center;">
            <div style="display:flex;">
            <img src="{{ asset('storage/' . $employee->image) }}" alt="Profile Image" width="50" height="50" style="border-radius:50%;">    
            <p style="color:blue;">@_{{ $employee->name }}</p>
            </div>
                <div style="display:flex; gap:20px;">
                    @if($user->role != 'performer')
                        <a href="/requestofassigner/{{$employee->id}}">Add Contact</a>
                    @endif        
                    <a href="/show/{{ $employee->id }}">about</a>
                </div>
            </div>
        @endforeach
        </div>

        <div id="employer" class="content-tab">
        @foreach($employers as $employer)
            <div class="contact" style="display: flex; justify-content: space-between; align-items: center;">
                <p style="color:blue;">@_{{ $employer->name }}</p>
                <div style="display:flex; gap:20px;">
                    @if($user->role != 'assignment')
                        <a href="/requestofperformer/{{ $employer->id }}">Add Contact</a>  
                    @endif
                    <a href="/show/{{ $employer->id }}">about</a>
                </div>
            </div>
        @endforeach
        </div>
    </div>
</div>

<script>
    document.getElementById('search').addEventListener('input', (event) => {
    let x = document.getElementById('search').value.toLowerCase();  // Convert to lowercase for case-insensitive matching
    document.querySelectorAll('.contact').forEach(item => {
        let name = item.querySelector('p').innerText.toLowerCase();  // Convert name to lowercase for case-insensitive matching
        if (name.includes(x)) {  // Use includes for partial matching
            item.style.display = "flex";  // Show the item if it matches the search input
        } else {
            item.style.display = "none";  // Hide the item if it doesn't match
        }
    });
});

</script>

<script>
    
    let msg = "{{ session('msg') }}";
    if(msg){
        alert(msg);
    }

    function toggleTab(tab) {
    // Hide both sections initially
    document.getElementById('employee').classList.remove('show');
    document.getElementById('employer').classList.remove('show');
    
    // Show the selected section
    if (tab === 'employee') {
        document.getElementById('employee').classList.add('show');
    } else if (tab === 'employer') {
        document.getElementById('employer').classList.add('show');
    }
}

// Initially, show the "Find Employee" tab by default
window.onload = function() {
    toggleTab('employee');
};

</script>
</body>
</html>
