<?php
class Transaction
{
    private $conn;
    private $products_table = 'products';
    private $sales_table = 'sales';
    private $product_sales_table = 'products_in_sales';
    private $inventory_table = 'daily_inventory_levels';

    /** Transaction Properties **/
    // Products Table
    public $product_id;
    public $product_type;
    public $product_size;
    public $product_variation;
    public $product_gender;
    public $default_unit_price;

    // Products in Sales Table
    public $product_quantity;
    public $unit_price;

    // Sales Table
    public $sales_id;
    public $transaction_date;
    public $venue_pay;
    public $total_earn;



    // Constructor w/ DB
    public function __construct($db)
    {
        $this->conn = $db;
    }


    /*** 
     * 
     * FUNCTION create()
     * Create new transaction
     * 
     ***/
    public function create()
    {

        // Query 1

        // Calculate total earnings and INSERT INTO sales table, include venue earn, or modify row later with total earnings
        $sales_query = 'INSERT INTO sales (date_of_sale, venue_pay) 
                   VALUES (":date_of_sale",":venue_pay");';

        // Prepare Statement
        $stmt = $this->conn->prepare($sales_query);

        // Sanitize Data
        $this->date_of_sale = htmlspecialchars(strip_tags($this->date_of_sale));
        $this->venue_pay = htmlspecialchars(strip_tags($this->venue_pay));

        // Bind Data
        $stmt->bindParam(':date_of_sale', $this->date_of_sale);
        $stmt->bindParam(':venue_pay', $this->venue_pay);

        // Execute Query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
        // Pull sales ID so we can detail the individual product transactions
        /* EXAMPLES
        ** PDO option
        **   $stmt = $db->prepare("...");
        **   $stmt->execute();
        **   $id = $db->lastInsertId();
        ** SQL option
        **   $stmt = $db->query("SELECT LAST_INSERT_ID()");
        **   $lastId = $stmt->fetchColumn();
        */

        // Query 2
        // Get product id by looking up matching product variations using form data. 

        // Query 3 +
        // Insert into products_in_sales by each product ID, use the same sale ID for each product in submitted sale. 
        // Altered prices need to be input as a separate row. 
    }

    /*** 
     * 
     * FUNCTION read()
     * Returns all transactions ordered by transaction_date DESC 
     * 
     ***/
    // public function read()
    // {
    //     // Create Query
    //     $query = 'SELECT 
    //                 c.name as category_name,
    //                 p.id,
    //                 p.category_id,
    //                 p.title,
    //                 p.body,
    //                 p.author,
    //                 p.created_at
    //                 FROM ' . $this->table . ' p
    //                 LEFT JOIN categories c 
    //                 ON p.category_ID = c.id
    //                 ORDER BY p.created_at DESC
    //               ';

    //     // Prepare Statement
    //     $stmt = $this->conn->prepare($query);

    //     // Execute Query
    //     $stmt->execute();

    //     return $stmt;
    // }
}