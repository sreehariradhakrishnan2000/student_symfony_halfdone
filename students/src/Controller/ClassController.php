<?php
// src/Controller/ClassController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/classes", name="classes_")
 */
class ClassController
{
    private $classes = []; // Replace with your database or storage mechanism

    /**
     * @Route("/", name="get_classes", methods={"GET"})
     */
    public function getClasses(): JsonResponse
    {
        return new JsonResponse(['classes' => $this->classes]);
    }

    /**
     * @Route("/{id}", name="get_class", methods={"GET"})
     */
    public function getClass($id): JsonResponse
    {
        $class = $this->findClassById($id);

        if (!$class) {
            return new JsonResponse(['error' => 'Class not found'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['class' => $class]);
    }

    /**
     * @Route("/", name="create_class", methods={"POST"})
     */
    public function createClass(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validate and sanitize input data as needed

        $newClass = [
            'id' => count($this->classes) + 1,
            'name' => $data['name'], // Assuming you have a 'name' property in your Class entity
        ];

        $this->classes[] = $newClass;

        return new JsonResponse(['message' => 'Class created', 'class' => $newClass], Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}", name="update_class", methods={"PUT"})
     */
    public function updateClass(Request $request, $id): JsonResponse
    {
        $classKey = $this->findClassKeyById($id);

        if ($classKey === null) {
            return new JsonResponse(['error' => 'Class not found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        // Validate and sanitize input data as needed

        $updatedClass = [
            'id' => $id,
            'name' => $data['name'], // Assuming you have a 'name' property in your Class entity
        ];

        $this->classes[$classKey] = $updatedClass;

        return new JsonResponse(['message' => "Class with ID $id updated", 'class' => $updatedClass]);
    }

    /**
     * @Route("/{id}", name="delete_class", methods={"DELETE"})
     */
    public function deleteClass($id): JsonResponse
    {
        $classKey = $this->findClassKeyById($id);

        if ($classKey === null) {
            return new JsonResponse(['error' => 'Class not found'], Response::HTTP_NOT_FOUND);
        }

        $deletedClass = $this->classes[$classKey];
        unset($this->classes[$classKey]);

        return new JsonResponse(['message' => "Class with ID $id deleted", 'class' => $deletedClass]);
    }

    // Helper function to find a class by ID
    private function findClassById($id)
    {
        foreach ($this->classes as $class) {
            if ($class['id'] == $id) {
                return $class;
            }
        }

        return null;
    }

    // Helper function to find the key of a class by ID
    private function findClassKeyById($id)
    {
        foreach (array_keys($this->classes) as $key) {
            if ($this->classes[$key]['id'] == $id) {
                return $key;
            }
        }

        return null;
    }
}
