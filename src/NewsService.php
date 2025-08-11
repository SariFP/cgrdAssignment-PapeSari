<?php
namespace User\CgrdassignmentPapeSari;

use PDO;

class NewsService
{
    public function __construct(private PDO $db) {}

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM news ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function create(string $title, string $content): bool
    {
        $stmt = $this->db->prepare("INSERT INTO news (title, content) VALUES (:title, :content)");
        return $stmt->execute([
            ':title' => $title,
            ':content' => $content
        ]);
    }

    public function update(int $id, string $title, string $content): bool
    {
        $stmt = $this->db->prepare("UPDATE news SET title=:title, content=:content WHERE id=:id");
        return $stmt->execute([
            ':title' => $title,
            ':content' => $content,
            ':id' => $id
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM news WHERE id=:id");
        return $stmt->execute([':id' => $id]);
    }
}
