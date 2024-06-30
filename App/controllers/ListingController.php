<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;


class ListingController {
    protected $db;

    public function __construct()
    {
        $config = require basePath("config/db.php");
        $this->db = new Database($config);
    }

    public function index() {
        $listings = $this->db->query("SELECT * FROM listings")->fetchAll();

        loadView("listings/index", [
            "listings" => $listings
        ]);
    }

    public function create() {
        loadView("listings/create");
    }

    public function show($params) {
        $id = $params["id"] ?? "";

        $params = [
            "id" => $id
        ];

        $listing = $this->db->query("SELECT * FROM listings WHERE id = :id", $params)->fetch();

        //check if listings exists
        if (!$listing) {
            ErrorController::notFound("Listings not found");
            return;
        }

        loadView("listings/show", [
            "listing" => $listing
        ]);
    }
   

    /**
     *   Store data in database
     * 
     *    @return void
     */
    public function store() {

        $allowedFields = ["title","description","salary","requirements","benefits","company","address","city","state","phone","email","tags"];

        $newListingData = array_intersect_key($_POST, array_flip($allowedFields));
        

        $newListingData["user_id"] = 1;

        $newListingData = array_map("sanitize", $newListingData); 

        $requiredFields = ["title", "description", "salary", "email", "city", "state",];

        $errors = [];

        foreach ($requiredFields as $field) {
            if(empty($newListingData[$field]) ||            !Validation::string($newListingData[$field])) {
                $errors[$field] = ucfirst($field) . " is required";
            }
        }

        if (!empty($errors)) {
            //Reload view with errors
            loadView("listings/create", [
                "errors" => $errors,
                "listing" => $newListingData
            ]);
        }
        else {
            //submit the data

            $fields = [];

            foreach($newListingData as $field => $value) {
                 $fields[] = $field;   
            }

            $fields = implode(", ", $fields);
           
            $values = [];

            foreach($newListingData as $field => $value) {
                // Convert empty string to null  
                if ($values === "") {
                    $newListingData[$field] = null;
                }
                $values[] = ":" . $field;
            } 

            $values = implode(", ", $values);

            $query = "INSERT INTO listings ({$fields}) VALUES ({$values})";

            $this->db->query($query, $newListingData);

            redirect("/listings");
        }
    } 
}