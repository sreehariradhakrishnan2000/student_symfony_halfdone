<?php
// src/Controller/StudentsController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/students", name="students_")
 */
class StudentsController extends AbstractController
{
    private $students = []; // Replace with your database or storage mechanism

    public function index(): JsonResponse
    {
        // Replace these values with your actual database credentials
        $host = 'localhost';
        $port = '5432';
        $dbname = 'student';
        $user = 'postgres';
        $password = '12345';

        try {
            // Connect to the PostgreSQL database
            $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";
            $pdo = new PDO($dsn);

            // Set the PDO error mode to exception
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Execute a SELECT query
            $query = "SELECT * FROM students";
            $statement = $pdo->query($query);

            // Fetch the results as an associative array
            $students = $statement->fetchAll(PDO::FETCH_ASSOC);

            // Render a template with the data
            return $this->render('students/index.php', [        
                'students' => $students,
            ]);
        } catch (\PDOException $e) {
            // Handle database connection errors
            return new JsonResponse(['error' => 'Connection failed: ' . $e->getMessage()], 500);
        } finally {
            // Close the database connection
            $pdo = null;
        }
    }
 
    /**
     * @Route("/students/{id}    ", name="get_students", methods={"GET"})
     */

    public function getStudents(): JsonResponse
    {
        return new JsonResponse(['students' => $this->students]);
    }

    /**
     * @Route("/studentsget{id}", name="get_student", methods={"GET"})
     */
    public function getStudent($id): JsonResponse
    {
        $student = $this->findStudentById($id);

        if (!$student) {
            return new JsonResponse(['error' => 'Student not found'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['student' => $student]);
    }

    /**
     * @Route("/create", name="create_student", methods={"POST"})
     */
    public function createStudent(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validate and sanitize input data as needed

        $newStudent = [
            'id' => count($this->students) + 1,
            'name' => $data['name'], // Assuming you have a 'name' property in your Student entity
        ];

        $this->students[] = $newStudent;

        return new JsonResponse(['message' => 'Student created', 'student' => $newStudent], Response::HTTP_CREATED);
    }

    /**
     * @Route("/studentsput/{id}", name="update_student", methods={"PUT"})
     * 
     */
    public function updateStudent(Request $request, $id): JsonResponse
    {
        $studentKey = $this->findStudentKeyById($id);

        if ($studentKey === null) {
            return new JsonResponse(['error' => 'Student not found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        // Validate and sanitize input data as needed

        $updatedStudent = [
            'id' => $id,
            'name' => $data['name'], // Assuming you have a 'name' property in your Student entity
        ];

        $this->students[$studentKey] = $updatedStudent;

        return new JsonResponse(['message' => "Student with ID $id updated", 'student' => $updatedStudent]);
    }

    /**
     * @Route("/studentsdelete/{id}", name="delete_student", methods={"DELETE"})
     */
    public function deleteStudent($id): JsonResponse
    {
        $studentKey = $this->findStudentKeyById($id);

        if ($studentKey === null) {
            return new JsonResponse(['error' => 'Student not found'], Response::HTTP_NOT_FOUND);
        }

        $deletedStudent = $this->students[$studentKey];
        unset($this->students[$studentKey]);

        return new JsonResponse(['message' => "Student with ID $id deleted", 'student' => $deletedStudent]);
    }

    // Helper function to find a student by ID
    private function findStudentById($id)
    {
        foreach ($this->students as $student) {
            if ($student['id'] == $id) {
                return $student;
            }
        }

        return null;
    }

    // Helper function to find the key of a student by ID
    private function findStudentKeyById($id)
    {
        foreach (array_keys($this->students) as $key) {
            if ($this->students[$key]['id'] == $id) {
                return $key;
            }
        }

        return null;
    }
}
