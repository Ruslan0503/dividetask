<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>taskperforming</title>
</head>
<style>
    /* Hover effect for file input label */
    .custom-file-container label:hover {
        background-color: #0056b3;
        transform: scale(1.05); /* Slight zoom effect */
    }

    /* Hover effect for the submit button */
    input[type="submit"]:hover {
        background-color: #218838; /* Darker green on hover */
        transform: scale(1.05); /* Slight zoom effect */
    }

    /* Focus effect for text area */
    textarea:focus {
        border-color: #007BFF; /* Blue border on focus */
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Blue shadow for focus */
        outline: none; /* Remove default outline */
    }

    /* Focus effect for file input */
    input[type="file"]:focus + label {
        background-color: #0056b3; /* Blue background on focus */
    }

    /* Focus effect for submit button */
    input[type="submit"]:focus {
        background-color: #218838; /* Darker green */
        outline: none;
    }
</style>

<body>
    <div class="container" style="text-align: center;">
        <h1>Assignment: {{ $task->TaskText }}</h1>
        <form action="{{ route('submittask', ['idoftask'=>$task->id]) }}" method="post" enctype="multipart/form-data" style="max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f9f9f9; border-radius: 10px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); display: flex; flex-direction: column; align-items: center;">
            @csrf
            <!-- Textarea -->
            <textarea name="description" id="description" cols="200" rows="20" style="width: 100%; padding: 15px; border: 2px solid #ddd; border-radius: 8px; font-size: 16px; color: #333; margin-bottom: 20px; resize: none;"></textarea>
            
            <!-- Custom File Input -->
            <div class="custom-file-container" style="position: relative; width: 100%; margin-bottom: 20px;">
                <input type="file" name="file" id="file" accept=".jpg,.jpeg,.png,.gif,.bmp,.pdf,.doc,.docx,.xls,.xlsx,.txt,.mp4,.avi,.mov,.wmv,.mpg,.mpeg" style="visibility: hidden; position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 2;" />
                <label for="file" style="width: 96%; padding: 15px 12px; background-color: #007BFF; color: white;  font-size: 16px; font-weight: bold; border-radius: 8px; cursor: pointer; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: background-color 0.3s ease; display: flex; justify-content: center; align-items: center;">
                    Choose a file to upload
                </label>
            </div>
        
            <!-- Submit Button -->
            <input type="submit" value="Submit" style="width: 100%; padding: 15px 20px; background-color: #28a745; color: white; border: none; font-size: 16px; font-weight: bold; border-radius: 8px; cursor: pointer; transition: background-color 0.3s ease; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        </form>
        
        
    </div>
</body>
</html>