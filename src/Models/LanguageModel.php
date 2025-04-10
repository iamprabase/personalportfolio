<?php
namespace App\Models;

class LanguageModel  extends BaseModel {
    
    public function getAllLanguages(): array {
        $stmt = $this->pdo->query("SELECT * FROM languages");
        return $stmt->fetchAll();
    }
}