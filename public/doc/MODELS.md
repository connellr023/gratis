<h1 align="center">
 <img src="https://github.com/connellr023/gratis/blob/main/public/images/logo_small.png?raw=true" width="150px" />
 <br />
 <div>Models</div>
</h1>

> [Back To Index](INDEX.md)

<br />

### Creating Models
A model is a class that extends the `AbstractModel` abstract class. Every model has access
to a configured `Database` instance that allows them to perform **SQL** database I/O.

#### Example
Consider a **SQL** database that contains the following schema for a *users* table,
```sql
CREATE TABLE users
(
    user_id  INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50)  NOT NULL UNIQUE,
    email    VARCHAR(100) NOT NULL UNIQUE
);
```

A model to represent an entry in the *users* table can be defined as follows,

> *db.php*
```php
use Gratis\Framework\AbstractModel;
use Gratis\Framework\Database\Database;

require_once __DIR__ . "../vendor/autoload.php";

$db = new Database(...); // Enter SQL database connection as parameters

// Must configure database instance in order for models to access it
AbstractModel::configure_db_instance($db);
```

<br />

> *User.php*
```php
use Gratis\Framework\AbstractModel;
use Gratis\Framework\Exceptions\GratisException;

class User extends AbstractModel
{
    private int $user_id;
    private string $username;
    private string $email;

    public function __construct(string $username, string $email, int $user_id = -1)
    {
        parent::__construct();

        $this->user_id = $user_id;
        $this->username = $username;
        $this->email = $email;
    }

    public static function fetch_user(int $user_id): self|false
    {
        try {
            self::get_db()->execute_prepared_statement("SELECT * FROM users WHERE user_id = :id;", [":id" => $user_id]);
            $res = self::get_db()->fetch_assoc();

            return new self(
                intval($res["user_id"]), // Ensure that user_id field is an integer
                $res["username"],
                $res["email"]
            );
        } catch (GratisException) {
            return false;
        }
    }

    public function insert(): bool
    {
        try {
            self::get_db()->execute_prepared_statement(
                "INSERT INTO users (username, email) VALUES (:username, :email)",
                [
                    ":username" => $this->username,
                    ":email" => $this->email
                ]
            );

            // Update user ID
            $this->user_id = intval(self::get_db()->fetch_last_insert_id());

            return true;
        } catch (GratisException) {
            return false;
        }
    }

    public function get_id(): int
    {
        return $this->user_id;
    }

    public function get_username(): string
    {
        return $this->username;
    }

    public function get_email(): string
    {
        return $this->email;
    }
}
```
The above *user* model class can be used to fetch and insert to and from the *users* table.

<br />

The `AbstractModel` class is more of a utility than a requirement. In reality, you can define a model
class however you want without the use of what this framework provides.