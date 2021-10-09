<?php

namespace App\Services;

require '../vendor/autoload.php';

use Kreait\Firebase\Factory; 

class FirebaseService
{
    private $firebase;
    public $db;
    public function __construct()
    {
        $this->firebase = (new Factory)->withServiceAccount('../app/Key/energy-of-water-fa56e2ee91f0.json');
        $this->db = $this->firebase->createDatabase();
    }

    
}