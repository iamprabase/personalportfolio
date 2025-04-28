<?php
namespace App\Models;

class LanguageModel extends BaseModel
{

  public function getAllLanguages(): array
  {
    return [
      ['code' => 'en', 'name' => 'English'],
      ['code' => 'fr', 'name' => 'French'],
    ];
  }
}
