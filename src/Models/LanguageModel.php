<?php
namespace App\Models;

class LanguageModel  extends BaseModel {
    
    public function getAllLanguages(): array {
        // // Return a predefined list of languages
        // return [
        //     ['code' => 'en', 'name' => 'English'],
        //     ['code' => 'fr', 'name' => 'French'],
        // ];
        
        $stmt = $this->pdo->query("SELECT * FROM languages");
        return $stmt->fetchAll();
    }
}