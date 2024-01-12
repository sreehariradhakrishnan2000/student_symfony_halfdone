<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
</head>
<body>
 
    <div class="container mt-5">
        <h1 class="mb-4">Edit Student</h1>

        <!-- Replace 'YourFormType' with the actual form type you've created -->
        <form action="{{ path('your_update_route', {'id': student.id}) }}" method="post">
            <!-- ID Field -->
            <div class="mb-3">
                <label for="id">ID:</label>
                <input type="text" class="form-control" id="id" name="id" value="{{ student.id }}" readonly>
            </div>

            <!-- Name Field -->
            <div class="mb-3">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ student.name }}" required>
            </div>

            <!-- Email Field -->
            <div class="mb-3">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ student.email }}" required>
            </div>

            <!-- Add more fields as needed -->

            <button type="submit" class="btn btn-primary">Update</button>
        </form>

        <a href="{{ path('students_index') }}" class="btn btn-secondary mt-3">Back to students</a>
    </div>

</body>
</html>
