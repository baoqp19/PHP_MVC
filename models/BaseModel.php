<?php
class BaseModel
{
    protected $table;
    protected $pdo;

    // kết nối Database
    public function __construct()
    {
        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8', DB_HOST, DB_PORT, DB_NAME);

        try {
            $this->pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
        } catch (PDOException $e) {
            die("Kết nối cơ sở dữ liệu thất bại: {$e->getMessage()} . Vui lòng thử lại.");
        }
    }

    // hủy Database
    public function __destruct()
    {
        $this->pdo = null;
    }

    // select 
    public function select($columns = '*', $conditions = null, $params = [])
    {

        $sql = "SELECT $columns FROM {$this->table}";

        if ($conditions) {
            $sql .= " WHERE $conditions";
        }
        
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    // count 
    
    public function count($conditions = null, $params = []){
        $sql = "SELECT COUNT(*) FROM {$this->table}";
        if($conditions){
            $sql .= " WHERE $conditions";
        }

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($params);

        return $stmt->fetchColumn();

    }

    // phân trang

    public function paginate($page = 1, $perPage = 5, $columns = '*', $conditions = null, $params = []){
        $sql = "SELECT $columns FROM {$this->table}";

        if($conditions){
            $sql .= " WHERE $conditions";
        }

        $offset = ($page - 1) * $perPage;

        $sql .= " LIMIT $perPage OFFSET $offset";
        
        // echo $sql; die;

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($params);
        return $stmt->fetchAll();


    }

    // find

    public function find($columns = '*', $conditions = null, $params = []){
        $sql = "SELECT $columns FROM {$this->table}";

        if($conditions){
            $sql .= " WHERE $conditions";
        }

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($params);
        return $stmt->fetch();


    }

    // insert

     public function insert($data){
        $keys = array_keys($data);   // name, price

        $columns = implode(',', $keys);

      
        // :name, :price
        $palceholders = ':' . implode(', :', $keys);

        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($palceholders)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($data);

        return $this->pdo->lastInsertId(); // hiện thị ra thông báo sau cùng
     }
     

     // update

     public function update($data, $conditions = null, $params = [])
     {
         $keys = array_keys($data);
 
         $arraySets = array_map(fn($key) => "$key = :set_$key", $keys);
 
         $sets = implode(', ', $arraySets);
 
         $sql = "UPDATE {$this->table} SET $sets";
 
         if ($conditions) {
             $sql .= " WHERE $conditions";
         }
 
         $stmt = $this->pdo->prepare($sql);
 
         // bindParam trong set
         foreach ($data as $key => &$value) {
             $stmt->bindParam(":set_$key", $value);
         }
 
         // bindParam trong where
         foreach ($params as $key => &$value) {
             $stmt->bindParam(":$key", $value);
         }
 
         $stmt->execute();
 
         return $stmt->rowCount();
     }



    // delete
    public function delete($conditions = null, $params = []){
        $sql = "DELETE FROM {$this->table}";

        if($conditions){
            $sql .= " WHERE $conditions";
        }

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($params);
        return $stmt->fetchAll();


    }

}
