<?php

// src/Controller/SubjectController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/subjects", name="subjects_")
 */
class SubjectController
{
    private $subjects = []; // Replace with your database or storage mechanism

    /**
     * @Route("/", name="get_subjects", methods={"GET"})
     */
    public function getSubjects(): JsonResponse
    {
        return new JsonResponse(['subjects' => $this->subjects]);
    }

    /**
     * @Route("/{id}", name="get_subject", methods={"GET"})
     */
    public function getSubject($id): JsonResponse
    {
        $subject = $this->findSubjectById($id);

        if (!$subject) {
            return new JsonResponse(['error' => 'Subject not found'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['subject' => $subject]);
    }

    /**
     * @Route("/", name="create_subject", methods={"POST"})
     */
    public function createSubject(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validate and sanitize input data as needed

        $newSubject = [
            'id' => count($this->subjects) + 1,
            'name' => $data['name'], // Assuming you have a 'name' property in your Subject entity
        ];

        $this->subjects[] = $newSubject;

        return new JsonResponse(['message' => 'Subject created', 'subject' => $newSubject], Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}", name="update_subject", methods={"PUT"})
     */
    public function updateSubject(Request $request, $id): JsonResponse
    {
        $subjectKey = $this->findSubjectKeyById($id);

        if ($subjectKey === null) {
            return new JsonResponse(['error' => 'Subject not found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        // Validate and sanitize input data as needed

        $updatedSubject = [
            'id' => $id,
            'name' => $data['name'], // Assuming you have a 'name' property in your Subject entity
        ];

        $this->subjects[$subjectKey] = $updatedSubject;

        return new JsonResponse(['message' => "Subject with ID $id updated", 'subject' => $updatedSubject]);
    }

    /**
     * @Route("/{id}", name="delete_subject", methods={"DELETE"})
     */
    public function deleteSubject($id): JsonResponse
    {
        $subjectKey = $this->findSubjectKeyById($id);

        if ($subjectKey === null) {
            return new JsonResponse(['error' => 'Subject not found'], Response::HTTP_NOT_FOUND);
        }

        $deletedSubject = $this->subjects[$subjectKey];
        unset($this->subjects[$subjectKey]);

        return new JsonResponse(['message' => "Subject with ID $id deleted", 'subject' => $deletedSubject]);
    }

    // Helper function to find a subject by ID
    private function findSubjectById($id)
    {
        foreach ($this->subjects as $subject) {
            if ($subject['id'] == $id) {
                return $subject;
            }
        }

        return null;
    }

    // Helper function to find the key of a subject by ID
    private function findSubjectKeyById($id)
    {
        foreach (array_keys($this->subjects) as $key) {
            if ($this->subjects[$key]['id'] == $id) {
                return $key;
            }
        }

        return null;
    }
}
