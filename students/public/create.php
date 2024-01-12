<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Student</title>
</head>
<body>
 
    <div class="container mt-5">
        <h1 class="mb-4">Create Student</h1>

        <!-- Replace 'YourFormType' with the actual form type you've created -->
        <form action="{{ path('your_create_route') }}" method="post">
            <!-- ID Field (assuming it's an auto-incremented field) -->
            <div class="mb-3">
                <label for="id">ID:</label>
                <input type="text" class="form-control" id="id" name="id" required>
            </div>

            <!-- Name Field -->
            <div class="mb-3">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <!-- Email Field -->
            <div class="mb-3">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <!-- Date of Birth (DOB) Field -->
            <div class="mb-3">
                <label for="dob">Date of Birth:</label>
                <input type="date" class="form-control" id="dob" name="dob" required>
            </div>


            <button type="submit" class="btn btn-primary">Create</button>
        </form>

        <a href="{{ path('students_index') }}" class="btn btn-secondary mt-3">Back to students</a>
    </div>

</body>
</html>
