<h1 align="center">
 <img src="https://github.com/connellr023/gratis/blob/main/public/images/logo_small.png?raw=true" width="150px" />
 <br />
 <div>Database Class</div>
</h1>

> [Back To Index](INDEX.md)

<br />

### Overview
```php
class Database implements IDatabase
```
The `Database` class is a tool that encapsulates a `PDO` and `PDOStatement` object in order to streamline
**SQL** database I/O and abstract away features that may be unnecessary in most cases.

### Constructor

```php
__construct(string $hostname, string $db_name, string $username, string $password, string $driver, int $port = 3306)
```

Creates a new `Database` instance and initializes a `PDO` connection to the specified database.

- **Parameters:**
    - `$hostname` (string): The hostname of the database.
    - `$db_name` (string): The name of the database.
    - `$username` (string): The username to interact with the database under.
    - `$password` (string): The user's password.
    - `$driver` (string): The driver to be used by this database instance. Must be one of the following:
        - "mysql"
        - "cubrid"
        - "mssql"
        - "sybase"
        - "dblib"
        - "firebird"
        - "ibm"
        - "informix"
        - "oci"
        - "odbc"
        - "pgsql"
        - "sqlite"
        - "sqlsrv"
    - `$port` (int, optional): The port that the database is running on. Default is `3306`.

- **Throws:**
    - `GratisException`: If connection fails or configuration of `PDO` fails.

### Methods

#### 1. 
```php
execute_query(string $sql): void
```

Executes an SQL query against the connected database.

- **Parameters:**
    - `$sql` (string): The SQL instruction to be executed.

- **Returns:**
    - `void`

- **Throws:**
    - `GratisException`: If the query fails to execute.

<br />

#### 2.
```php
execute_prepared_statement(string $sql, array $params): void
```

Prepares an SQL query and inserts a sequence of parameters into their respective positions denoted by "?" or ":param" placeholders.

- **Parameters:**
    - `$sql` (string): The SQL command to be prepared.
    - `$params` (array): The parameters to be inserted.

- **Returns:**
    - `void`

- **Throws:**
    - `GratisException`: If the query fails to prepare or execute.

<br />

#### 3. 
```php
fetch_assoc(): array
```

Fetches an associative array of values based on the `SELECT` query that was just executed.

- **Returns:**
    - `array`: Associative array of values.

- **Throws:**
    - `GratisException`: If the values fail to be retrieved.

<br />

#### 4.
```php
fetch_last_insert_id(?string $field_name = null): string
```

Gets the ID of the last row inserted into a table.

- **Parameters:**
    - `$field_name` (string|null): The name of the field containing the last insert ID.

- **Returns:**
    - `string`: The last insert ID.

- **Throws:**
    - `GratisException`: If reading the last insert ID fails.

<br />

## Example Usage

```php
// Instantiate a Database object with a database connection
try {
    $db = new Database("localhost", "my_database", "username", "password", "mysql");
} catch (GratisException $e) {
    echo "Error: " . $e->getMessage();
}


// Example 1: Execute a simple query
$db->execute_query("DELETE FROM users WHERE id = 123");

// Example 2: Prepare and execute a statement with parameters
$sql = "INSERT INTO products (name, price) VALUES (:name, :price)";
$params = ["name" => "Product A", "price" => 19.99];
$db->execute_prepared_statement($sql, $params);

// Example 3: Fetch results from a SELECT query
$results = $db->fetch_assoc();
print_r($results);

// Example 4: Fetch the last insert ID
$last_insert_id = $db->fetch_last_insert_id();
echo "Last Insert ID: " . $last_insert_id;
```